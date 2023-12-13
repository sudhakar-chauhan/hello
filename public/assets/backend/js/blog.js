
import { baseUrl, uploadImage } from "./custom.js";


$(document).ready(function(){


    $(document).on("click", ".edit-wrapper-blog .quick-edit", function () {
        let clickBtn = $(this);
        let id = $(this).data("id");
    
        $(this).append(
          "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
        );
        $(this).attr('disabled', true);
        getBlogDetail(id)
          .then(function (data) {
            data = data[0];
            clickBtn.attr('disabled', false);
    
    
            getBlogCategory()
             .then(function(data){
              $('#category').append(data);
            })
            .catch(function(error){
              console.log(error);
            })
            let form = `  <td class="quick-edit-wrapper" colspan="5">
    
            <div class="">
                <form action="http://localhost/richmane/admin/blog/edit" id="editFormBlog" autocompleete="off"
                 class="row px-3 editFormAll " method="post" accept-charset="utf-8">
                    <div id="errorWrapper"></div>
        
                    <div class="form-outline mb-4 col-4">
                        <label for="heading" class="from-label">heading</label>
                        <input type="text" name="heading" id="heading" value="${
                          data["heading"]
                        }" placeholder="Heding*" class="form-control" reqiured>
        
                    </div>
                    <div class="form-outline mb-4 col-4">
                        <label for="slug" class="from-label">Slug</label>
                        <input type="text" name="slug" value="${
                          data["blog_slug"]
                        }" id="slug" placeholder="slug*" class="form-control" reqiured>
        
                    </div>
                    <div class="form-outline mb-4 col-4">
                        <label for="author" class="from-label">Author</label>
                        <input type="text" name="author" value="${
                          data["created_by"]
                        }" id="author" placeholder="Author*" class="form-control" reqiured>
        
                    </div>
                    <div class="form-outline mb-4 col-4">
                        <label for="category" class="from-label">Category</label>
                        <select name="category" class="form-select" id="category">
                            <option value="${
                              data["blog_category_id"]
                            }" selected="selected">${data["category_name"]}</option>
                        </select>
                    </div>
        
                    <div class="form-outline mb-4 col-4">
                    <label for="isActive" class="from-label">Active</label>
                    <select name="isActive" class="form-select" id="isActive">
                        <option value="1" ${
                          data["is_active"] == 1 ? "selected " : ""
                        }">Active</option>
                        <option value="0" ${
                          data["is_active"] == 0 ? "selected " : ""
                        }>Not Active</option>
                    </select>
                </div>
                    <div class="d-none">
                    <input type="text" name="oldImage" id="oldImage" value="${
                      data["feature_image"]
                    }">
                   </div>
                    <div class="form-outline mb-4 col-6">
                    <img id="imagePreview" src="/richmane/public/assets/uploads/blog/${
                      data["feature_image"]
                    }" class="d-block mb-2 text-start" width="150" height="120">
        
                    <label for="featureImage" class="from-label pb-2">Feature Image</label>
                       <input type="file" id="featureImage" class="upload" name="featureImage" accept="image/*">
                       <span  id="image"></span>
    
                    </div>
                    <div class="button-wrappper">
                    <button type="button" id="update" class="btn btn-primary mb-3 me-3" data-id="${
                      data["blog_id"]
                    }" >Update</button>
                    <button type="button" id="cancel" class="btn text-black border border-black border-2 mb-3">Cancel</button>
        
        
                    </div>
                    
        
        
        
                </form>
            </div>
        </td>`;
    
            clickBtn.closest("tr").children("td").addClass("d-none");
            clickBtn.closest("tr").append(form);
    
            $(".spinner").remove();
          })
          .catch(function (error) {
            clickBtn.attr('disabled', false);
            $(".spinner").remove();
            console.error("Error: " + error);
          });
      });
    
  $(document).on("click", "#editFormBlog #update", function () {
    let clickBtn = $(this);
    let data = [];
    data["id"] = $(this).data("id");
    data["heading"] = $("#editFormBlog #heading").val();
    data["slug"] = $("#editFormBlog #slug").val();
    data["category"] = $("#editFormBlog #category").val();
    data["author"] = $("#editFormBlog #author").val();
    data["isActive"] = $("#editFormBlog #isActive").val();
    data["oldImage"] = $("#editFormBlog #oldImage").val();

    data["featureImage"] = "";

    let imageUploaded = $("#editFormBlog #featureImage")[0].files[0];

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
    $(this).attr('disabled', true);


    if (imageUploaded) {
   

      let formData = new FormData();
      formData.append("image", imageUploaded);
      formData.append("location", "public/assets/uploads/blog/");
      uploadImage(formData)
        .then(function (imgData) {
          data["featureImage"] = imgData["imageName"];

          updateBlogDetail(data)
            .then(function (data) {

              clickBtn.attr('disabled', false);
              clickBtn.closest("tr").children("td").removeClass("d-none");

              clickBtn.closest("tr").find('a.heading').html(data.heading);
              clickBtn.closest("tr").find('td.category').html(data.category);
              clickBtn.closest("tr").find('td.author').html(data.author);
              clickBtn.closest("tr").find('td a.heading').attr('href', baseUrl+'admin/edit-blog/' + data.slug);
              clickBtn.closest("tr").find('a.btnView').attr('href', baseUrl+'blog/' + data.slug);
              clickBtn.closest("tr").find('img').attr('src', baseUrl+'public/assets/uploads/blog/' + data.featureImage);


         $('td.quick-edit-wrapper').remove();
              $(".spinner").remove();
            })
            .catch(function (data) {
              $(".spinner").remove();
              clickBtn.attr('disabled', false);
              $(".errorMessage").remove();
              if (typeof data.error === "object") {
                $.each(data.error, function (field, error) {
                  $("#editFormBlog #" + field).addClass("error");
                  $(`<span class=" errorMessage">${error}</span>`).insertAfter(
                    "#editFormBlog #" + field
                  );
                });
                
              } else {
              
                console.error("Error: " + data.error);
              }
            });
        })
        .catch(function (data) {
          clickBtn.attr('disabled', false);
          $(".spinner").remove();
          $(this).attr('disabled', false);
          $(".errorMessage").remove();
          if (typeof data.error === "object") {
            $.each(data.error, function (field, error) {
              $("#editFormBlog #" + field).addClass("error");
              $(`<span class=" errorMessage">${error}</span>`).insertAfter(
                "#editFormBlog #" + field
              );
            });
          } else {
            console.error("Error: " + data.error);
          }
        });
    }else{
      updateBlogDetail(data)
      .then(function (data) {

        clickBtn.attr('disabled', false);
        clickBtn.closest("tr").children("td").removeClass("d-none");


        clickBtn.closest("tr").find('a.heading').html(data.heading);
        clickBtn.closest("tr").find('td.category').html(data.category);
        clickBtn.closest("tr").find('td.author').html(data.author);
        clickBtn.closest("tr").find('td a.heading').attr('href', baseUrl+'admin/edit-blog/' + data.slug);
        clickBtn.closest("tr").find('a.btnView').attr('href', baseUrl+'blog/' + data.slug);
        clickBtn.closest("tr").find('img').attr('src', baseUrl+'public/assets/uploads/blog/' + data.featureImage);


              $('td.quick-edit-wrapper').remove();

      })
      .catch(function (data) {
        $(".spinner").remove();
        clickBtn.attr('disabled', false)
        $(".errorMessage").remove();
        if (typeof data.error === "object") {
          $.each(data.error, function (field, error) {
            $("#editFormBlog #" + field).addClass("error");
            $(`<span class=" errorMessage">${error}</span>`).insertAfter(
              "#editFormBlog #" + field
            );
          });
        } else {
          clickBtn.attr('disabled', false);
          console.error("Error: " + data.error);
        }
      });
    }

  });


  $(document).on(
    "click",
    ".edit-wrapper-blog #deleteConfirm",
    function () {
      let id = $(this).data("id");

      let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteBlog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
  <!--Content-->
  <div class="modal-content text-center">
    <!--Header-->
    <div class="modal-header d-flex justify-content-center">
      <p class="heading">Are you sure?</p>
    </div>

    <!--Body-->
    <div class="modal-body">
       <p>You Want to Delete This Blog Id : ${id}</p>

    </div>

    <!--Footer-->
    <div class="modal-footer flex-center">
      <button type="button" id="confirm"  class="btn btn-danger" data-id="${id}">Yes</button>
      <button type="button" class="btn border border-2 text-black" id="deleteCancel">No</button>
    </div>
  </div>
  <!--/.Content-->
</div>
</div>`;

      $(".overlay").addClass("active");

      $("body").append(form);
    }
  );


  $(document).on("click", "#modalConfirmDeleteBlog #confirm", function () {
    let id = $(this).data("id");

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
    $(this).attr("disabled", true);

    deleteBlog(id)
      .then(function (data) {
        $(".overlay").removeClass("active");
        $(".modal").remove();
        $("#ct" + data.id).remove();

        alert("Blog is Delete Successfully");
      })
      .catch(function (error) {
        $(".overlay").removeClass("active");
        $(".modal").remove();
        alert(error);
        console.error("Error: " + error);
      });
  });


  $(document).on("click", "#bulkApplyBlog", function () {
    let action = $("#bulkSelect").val();

    let checkedIds = []; // An array to store the "data-id" values of checked checkboxes

    $('#datable_1 input[type="checkbox"]:checked').each(function () {
      let checkboxId = $(this).data("id");
      checkedIds.push(checkboxId);
    });

    if (action == "delete") {
      let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmBulkDeleteBlog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
  <!--Content-->
  <div class="modal-content text-center">
    <!--Header-->
    <div class="modal-header d-flex justify-content-center">
      <p class="heading">Are you sure?</p>
    </div>

    <!--Body-->
    <div class="modal-body">
       <p>You Want to Delete This Blog  Ids : ${checkedIds}</p>

    </div>

    <!--Footer-->
    <div class="modal-footer flex-center">
      <button type="button" id="confirmBulk"  class="btn btn-danger" data-id="[${checkedIds}]">Yes</button>
      <button type="button" class="btn border border-2 text-black" id="deleteCancel">No</button>
    </div>
  </div>
  <!--/.Content-->
</div>
</div>`;

      $(".overlay").addClass("active");

      $("body").append(form);
    }
  });

  $(document).on(
    "click",
    "#modalConfirmBulkDeleteBlog #confirmBulk",
    function () {
      let ids = $(this).data("id");


      $(this).attr('disabled', true);
      
    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
      bulkDeleteBlog(ids)
        .then(function (data) {
          $(".overlay").removeClass("active");
          $(".modal").remove();

          for (let x of data.ids) {
            $("#ct" + x).remove();
          }
          alert("Blog is Delete Successfully");
        })
        .catch(function (error) {
          $(".overlay").removeClass("active");
          $(".modal").remove();
          alert(error);
          console.error("Error: " + error);
        });
    });



// =============================== Category ===================== //



  $(document).on("click", "button#addNewBlogCategory", function () {
 
    let form = `
  <div class="modal fade in d-block" id="addNewBlogCategory" tabindex="-1" role="dialog" aria-labelledby="addNew"
aria-hidden="true">
<div class="modal-dialog  modal-notify modal-danger" role="document">
<!--Content-->
<div class="modal-content text-center">
  <!--Header-->
  <div class="modal-header d-flex justify-content-center">
    <p class="heading">Add New Category</p>
  </div>
  <div id="#errorWrapper"> </div>
  <!--Body-->
  <div class="modal-body">
  <form>
<div class="mb-3">
  <label for="categoryName" class="form-label">Category Name</label>
  <input type="text" class="form-control" id="categoryName" aria-describedby="categoryName">
</div>

  </div>

  <!--Footer-->
  <div class="modal-footer flex-center">
    <button type="button" id="add"  class="btn btn-primary" >Save</button>
    <button type="button" class="btn border border-2 text-black" id="modalClose">Close</button>
  </div>
  </form>
</div>
<!--/.Content-->
</div>
</div>`;

    $(".overlay").addClass("active");

    $("body").append(form);
  });


  $(document).on("click", "#addNewBlogCategory #add", function () {
    let data = [];
    let clickBtn = $(this);
    data["categoryName"] = $("#addNewBlogCategory #categoryName").val();

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );

    addBlogCategory(data)
      .then(function (data) {

        let form = `<tr role="row" class="even" id="ct${data.id}">
    <td>
        <input class="form-check-input" type="checkbox" name="checkbox" data-id="${data.id}">
    </td>
    <td><span class="category-name">${data.categoryName}</span>

        <div class=" edit-wrapper-all edit-wrapper-categories d-flex g-2 pt-2">
            <button type="btn" class="btn text-black ">ID: ${data.id}</button>
            <button type="button" class="btn text-black quick-edit" data-id="${data.id}">Quick Edit</button>
            <button type="button" class="btn text-danger " id="deleteConfirm" data-id="${data.id}">Delete</button>
            <a href="http://localhost/richmane/blog/cat/${data.slug}" type="button" class="btn text-black btnView">View</a>
        </div>

    </td>
    <td class="sorting_1 slug">${data.slug}</td>
    <td class="active"> ${data.active}</td>

</tr>`;

        $("#datable_1 tbody").prepend(form);

        $(".modal").remove();
        $(".overlay").removeClass("active");
        
        alert("Successfuly Category Added");
      })
      .catch(function (data) {
        $('.spinner').remove()
        clickBtn.attr("disabled", false);
        if (typeof data.error === "object") {
          $.each(data.error, function (field, error) {
            $("#addNewBlogCategory #" + field).addClass("error");
            $(`<span class=" errorMessage">${error}</span>`).insertAfter(
              "#addNewBlogCategory #" + field
            );
          });
        } else {
          console.error("Error: " + data.error);
          console.log(data)
        }
      });
  });

  $(document).on("click", ".edit-wrapper-blog-categories .quick-edit", function () {
    let clickBtn = $(this);
    let id = $(this).data("id");

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );

    $(this).attr("disabled", true);
    getBlogCategoryDetail(id)
      .then(function (data) {
        clickBtn.attr("disabled", false);

        data = data[0];

        let form = `  <td class="quick-edit-wrapper" colspan="5">

        <div class="">
            <form action="http://localhost/richmane/admin/product/edit"  id="editFormBlogCategory" autocompleete="off"
             class="row px-3 editFormAll" method="post" accept-charset="utf-8">
                <div id="errorWrapper"></div>
    
                <div class="form-outline mb-4 col-4">
                    <label for="categoryName" class="from-label">Name</label>
                    <input type="text" name="categoryName" id="categoryName" value="${data["category_name"]}" placeholder="category Name*" class="form-control" reqiured>
    
                </div>
          
                <div class="mb-3">
                   <label for="incFilter" class="form-label">Active</label>
                   <select class="form-select" id="active" name="active" aria-label="Default select example">
                  <option  value = "1" ${data["is_active"] == 1 ? "selected": ""}>Acitve</option>
                   <option value="0"  ${data["is_active"] == 0 ? "selected": ""}>In active</option>

                   </select>
</div>
                <div class="button-wrappper">
                <button type="button" id="update" class="btn btn-primary mb-3 me-3" data-id="${data["blog_category_id"]}" >Update</button>
                <button type="button" id="cancel" class="btn text-black border border-black border-2 mb-3">Cancel</button>
    
    
                </div>
    
    
    
            </form>
        </div>
    </td>`;

        clickBtn.closest("tr").children("td").addClass("d-none");
        clickBtn.closest("tr").append(form);

        $(".spinner").remove();
      })
      .catch(function (error) {
        clickBtn.attr("disabled", false);
        $(".spinner").remove();
        console.error("Error: " + error);
      });
  });



  $(document).on("click", "#editFormBlogCategory #update", function () {
    let clickBtn = $(this);
    let data = [];
    data["id"] = $(this).data("id");
    data["categoryName"] = $("#editFormBlogCategory #categoryName").val();
    data["active"] = $("#editFormBlogCategory #active").val();

    $(this).attr("disabled", true);

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );

    updateBlogCategory(data)
      .then(function (data) {
        clickBtn.attr("disabled", false);
        clickBtn.closest("tr").children("td").removeClass("d-none");

        clickBtn
          .closest("tr")
          .find("td .category-name")
          .html(data.categoryName);
        clickBtn
          .closest("tr")
          .find("td.slug")
          .html(data.slug);
        clickBtn
          .closest("tr")
          .find("td.active")
          .html(data.active);

        $("td.quick-edit-wrapper").remove();
      })
      .catch(function (data) {
        $(".spinner").remove();
        clickBtn.attr("disabled", false);
        $(".errorMessage").remove();
        if (typeof data.error === "object") {
          $.each(data.error, function (field, error) {
            $("#editFormBlogCategory #" + field).addClass("error");
            $(`<span class=" errorMessage">${error}</span>`).insertAfter(
              "#editFormBlogCategory #" + field
            );
          });
        } else {
          clickBtn.attr("disabled", false);
          console.error("Error: " + data.error);
        }
      });
  });



  
  $(document).on(
    "click",
    ".edit-wrapper-blog-categories #deleteConfirm",
    function () {
      let id = $(this).data("id");

      let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteBlogCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
  <!--Content-->
  <div class="modal-content text-center">
    <!--Header-->
    <div class="modal-header d-flex justify-content-center">
      <p class="heading">Are you sure?</p>
    </div>

    <!--Body-->
    <div class="modal-body">
       <p>You Want to Delete This Category Id : ${id}</p>

    </div>

    <!--Footer-->
    <div class="modal-footer flex-center">
      <button type="button" id="confirm"  class="btn btn-danger" data-id="${id}">Yes</button>
      <button type="button" class="btn border border-2 text-black" id="deleteCancel">No</button>
    </div>
  </div>
  <!--/.Content-->
</div>
</div>`;

      $(".overlay").addClass("active");

      $("body").append(form);
    }
  );



  $(document).on("click", "#modalConfirmDeleteBlogCategory #confirm", function () {
    let id = $(this).data("id");

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
    $(this).attr("disabled", true);

    deleteBlogCategory(id)
      .then(function (data) {
        $(".overlay").removeClass("active");
        $(".modal").remove();
        $("#ct" + data.id).remove();

        alert("Category is Delete Successfully");
      })
      .catch(function (error) {
        $(".overlay").removeClass("active");
        $(".modal").remove();
        alert(error);
        console.error("Error: " + error);
      });
  });

  //  =========================== Delete Product Bulk ====================== //

  $(document).on("click", "#bulkApplyBlogCategory", function () {
    let action = $("#bulkSelect").val();

    let checkedIds = []; // An array to store the "data-id" values of checked checkboxes

    $('#datable_1 input[type="checkbox"]:checked').each(function () {
      let checkboxId = $(this).data("id");
      checkedIds.push(checkboxId);
    });

    if (action == "delete") {
      let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteBlogCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
  <!--Content-->
  <div class="modal-content text-center">
    <!--Header-->
    <div class="modal-header d-flex justify-content-center">
      <p class="heading">Are you sure?</p>
    </div>

    <!--Body-->
    <div class="modal-body">
       <p>You Want to Delete This Category  Ids : ${checkedIds}</p>

    </div>

    <!--Footer-->
    <div class="modal-footer flex-center">
      <button type="button" id="confirmBulk"  class="btn btn-danger" data-id="[${checkedIds}]">Yes</button>
      <button type="button" class="btn border border-2 text-black" id="deleteCancel">No</button>
    </div>
  </div>
  <!--/.Content-->
</div>
</div>`;

      $(".overlay").addClass("active");

      $("body").append(form);
    }
  });

  $(document).on(
    "click",
    "#modalConfirmDeleteBlogCategory #confirmBulk",
    function () {
      let ids = $(this).data("id");

      bulkDeleteBlogCategory(ids)
        .then(function (data) {
          $(".overlay").removeClass("active");
          $(".modal").remove();

          for (let x of data.ids) {
            $("#ct" + x).remove();
          }

          alert("Category is Delete Successfully");
        })
        .catch(function (error) {
          $(".overlay").removeClass("active");
          $(".modal").remove();
          alert(error);
          console.error("Error: " + error);
        });
    }
  );


// ============== Get Product Detail ===================== //
function getBlogDetail(id) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "admin/blog/" + id,
        type: "GET",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        data: {},
        success: function (response) {
          if (response.status === "success") {
            resolve(response.data); // Resolve the promise with the response data
          } else {
            reject(response.message); // Reject the promise with an error message
          }
        },
        error: function (xhr, status, error) {
          reject(error); // Reject the promise with the error message
        },
      });
    });
  }
  function getBlogCategory() {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "admin/blog-category/",
        type: "GET",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        data: {},
        success: function (response) {
          if (response.status === "success") {
            resolve(response.data); // Resolve the promise with the response data
          } else {
            reject(response.message); // Reject the promise with an error message
          }
        },
        error: function (xhr, status, error) {
          reject(error); // Reject the promise with the error message
        },
      });
    });
  }


  
  function updateBlogDetail(data) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/blog",
        type: "POST",

        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        data: {
          ...data,
        },
        success: function (response) {
          if (response.status === "success") {
            resolve(response.data); // Resolve the promise with the response data
          } else {
            reject(response.data); // Reject the promise with an error message
          }
        },
        error: function (xhr, status, error) {
          reject(error); // Reject the promise with the error message
        },
      });
    });
  }


  
  function deleteBlog(id) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/blog/" + id,
        type: "DELETE",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        data: {},
        success: function (response) {
          if (response.status === "success") {
            resolve(response.data); // Resolve the promise with the response data
          } else {
            reject(response.message); // Reject the promise with an error message
          }
        },
        error: function (xhr, status, error) {
          reject(error); // Reject the promise with the error message
        },
      });
    });
  }

  function bulkDeleteBlog(ids){
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/blog/delete",
        type: "POST",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        data: {
          ids: ids
        },
        success: function (response) {
          if (response.status === "success") {
            resolve(response.data); // Resolve the promise with the response data
          } else {
            reject(response.message); // Reject the promise with an error message
          }
        },
        error: function (xhr, status, error) {
          reject(error); // Reject the promise with the error message
        },
      });
    });
  }



  // ==============  Add Categories===================== //
  function addBlogCategory(data) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/add-blog-category",
        type: "POST",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        data: {
          ...data,
        },
        success: function (response) {
          if (response.status === "success") {
            resolve(response.data); // Resolve the promise with the response data
          } else {
            reject(response.data); // Reject the promise with an error message
          }
        },
        error: function (xhr, status, error) {
          reject(error); // Reject the promise with the error message
        },
      });
    });
  }


  function getBlogCategoryDetail(id) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "admin/blog-category/" + id,
        type: "GET",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        data: {},
        success: function (response) {
          if (response.status === "success") {
            resolve(response.data); // Resolve the promise with the response data
          } else {
            reject(response.data); // Reject the promise with an error message
          }
        },
        error: function (xhr, status, error) {
          reject(error); // Reject the promise with the error message
        },
      });
    });
  }
  
  // ============== Update Product Details ===================== //

  function updateBlogCategory(data) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/blog-category",
        type: "POST",

        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        data: {
          ...data,
        },
        success: function (response) {
          if (response.status === "success") {
            resolve(response.data); // Resolve the promise with the response data
          } else {
            reject(response.data); // Reject the promise with an error message
          }
        },
        error: function (xhr, status, error) {
          reject(error); // Reject the promise with the error message
        },
      });
    });
  }


  function deleteBlogCategory(id) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/blog-category/" + id,
        type: "DELETE",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        data: {},
        success: function (response) {
          if (response.status === "success") {
            resolve(response.data); // Resolve the promise with the response data
          } else {
            reject(response.message); // Reject the promise with an error message
          }
        },
        error: function (xhr, status, error) {
          reject(error); // Reject the promise with the error message
        },
      });
    });
  }

  function bulkDeleteBlogCategory(ids) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/blog-category/delete",
        type: "POST",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        data: {
          ids: ids,
        },
        success: function (response) {
          if (response.status === "success") {
            resolve(response.data); // Resolve the promise with the response data
          } else {
            reject(response.message); // Reject the promise with an error message
          }
        },
        error: function (xhr, status, error) {
          reject(error); // Reject the promise with the error message
        },
      });
    });
  }
});