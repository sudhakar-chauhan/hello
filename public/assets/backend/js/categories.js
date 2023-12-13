import { baseUrl, uploadImage } from "./custom.js";
$(document).ready(function () {



  //  =============== Add new Category =========================//

  $(document).on("click", "button#addNewCategory", function () {
    getProductCategory()
      .then(function (data) {
        $("#parentCategory").append(data);
      })
      .catch(function (error) {
        console.log(error);
      });

    let form = `
  <div class="modal fade in d-block" id="addNewCategory" tabindex="-1" role="dialog" aria-labelledby="addNew"
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
<div class="mb-3">
<label for="parentCategory" class="form-label">Parent Category</label>

<select class="form-select" id="parentCategory" name="parentCategory" aria-label="Default select example">
<option  value="" selected>Select Parent Category</option>
<option value="">None</option>

</select>
</div>

<div class="mb-3">
<label for="incFilter" class="form-label">Include in Filter</label>
<select class="form-select" id="incFilter" name="incFilter" aria-label="Default select example">
<option  value = "1" selected>YES</option>
<option value="0">NO</option>

</select>
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


  $(document).on("click", "#addNewCategory #add", function () {
    let data = [];
    let clickBtn = $(this);
    data["categoryName"] = $("#addNewCategory #categoryName").val();
    data["parentCategory"] = $("#addNewCategory #parentCategory").val();
    data["incFilter"] = $("#addNewCategory #incFilter").val();

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );

    addCategory(data)
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
            <a href="http://localhost/richmane/shop/${data.slug}" type="button" class="btn text-black btnView">View</a>
        </div>

    </td>
    <td class="sorting_1 parent-category">${data.parentCategory}</td>
    <td class="count"><a href="http://localhost/richmane/shop/${data.slug}">  0</a></td>

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
            $("#addNewCategory #" + field).addClass("error");
            $(`<span class=" errorMessage">${error}</span>`).insertAfter(
              "#addNewCategory #" + field
            );
          });
        } else {
          console.error("Error: " + data.error);
          console.log(data)
        }
      });
  });

  $(document).on("click", ".edit-wrapper-categories .quick-edit", function () {
    let clickBtn = $(this);
    let categoryId = $(this).data("id");

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );

    $(this).attr("disabled", true);
    getCategoryDetail(categoryId)
      .then(function (data) {
        clickBtn.attr("disabled", false);

        data = data[0];
        getProductCategory()
          .then(function (data) {
            $("#parentCategory").append(data);
          })
          .catch(function (error) {
            console.log(error);
          });

        let form = `  <td class="quick-edit-wrapper" colspan="5">

        <div class="">
            <form action="http://localhost/richmane/admin/product/edit"  id="editFormCategory" autocompleete="off"
             class="row px-3 editFormAll" method="post" accept-charset="utf-8">
                <div id="errorWrapper"></div>
    
                <div class="form-outline mb-4 col-4">
                    <label for="categoryName" class="from-label">Name</label>
                    <input type="text" name="categoryName" id="categoryName" value="${data["child_category_name"]}" placeholder="Product Name*" class="form-control" reqiured>
    
                </div>
          
                <div class="form-outline mb-4 col-4">
                    <label for="parentCategory" class="from-label">Parent Category</label>
                    <select name="parentCategory" class="form-select" id="parentCategory">
                     <option value="">None</option>
                        <option value="${data["parent_category_id"]}" selected="selected">${data["parent_category_name"]}</option>
                        
    
    
    
                    </select>
    
                </div>

                <div class="mb-3">
                   <label for="incFilter" class="form-label">Include in Filter</label>
                   <select class="form-select" id="incFilter" name="incFilter" aria-label="Default select example">
                  <option  value = "1" ${data["inc_filter"] == 1 ? "selected": ""}>YES</option>
                   <option value="0"  ${data["inc_filter"] == 0 ? "selected": ""}>NO</option>

                   </select>
</div>
    
    
                <div class="button-wrappper">
                <button type="button" id="update" class="btn btn-primary mb-3 me-3" data-id="${data["category_id"]}" >Update</button>
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
  $(document).on("click", "#editFormCategory #update", function () {
    let clickBtn = $(this);
    let categoryData = [];
    categoryData["categoryId"] = $(this).data("id");
    categoryData["categoryName"] = $("#editFormCategory #categoryName").val();
    categoryData["incFilter"] = $("#editFormCategory #incFilter").val();
    categoryData["parentCategory"] = $(
      "#editFormCategory #parentCategory"
    ).val();

    $(this).attr("disabled", true);

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );

    updateCategory(categoryData)
      .then(function (data) {
        clickBtn.attr("disabled", false);
        clickBtn.closest("tr").children("td").removeClass("d-none");

        clickBtn
          .closest("tr")
          .find("td .category-name")
          .html(data.categoryName);
        clickBtn
          .closest("tr")
          .find("td.parent-category")
          .html(data.parentCategory);

        $("td.quick-edit-wrapper").remove();
      })
      .catch(function (data) {
        $(".spinner").remove();
        clickBtn.attr("disabled", false);
        $(".errorMessage").remove();
        if (typeof data.error === "object") {
          $.each(data.error, function (field, error) {
            $("#editFormCategory #" + field).addClass("error");
            $(`<span class=" errorMessage">${error}</span>`).insertAfter(
              "#editFormCategory #" + field
            );
          });
        } else {
          clickBtn.attr("disabled", false);
          console.error("Error: " + data.error);
        }
      });
  });


  // =============== Attributest categoriest ============ //

  $(document).on("click", ".edit-wrapper-attributes-categories .quick-edit", function () {
    let clickBtn = $(this);
    let categoryId = $(this).data("id");

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );

    $(this).attr("disabled", true);
    getAttributesCategoryDetail(categoryId)
      .then(function (data) {
        clickBtn.attr("disabled", false);

        data = data[0];
     

        let form = `  <td class="quick-edit-wrapper" colspan="5">

        <div class="">
            <form action="http://localhost/richmane/admin/attributes-category/edit" id="editFormAttributestCategory" autocompleete="off"
             class="row px-3" method="post" accept-charset="utf-8">
                <div id="errorWrapper"></div>
    
                <div class="form-outline mb-4 col-4">
                    <label for="attributeCategoryTitle" class="from-label">Title</label>
                    <input type="text" name="attributeCategoryTitle" id="attributeCategoryTitle" value="${data["title"]}" placeholder="Attribute Title*" class="form-control" reqiured>
    
                </div>
          
                <div class="form-outline mb-4 col-4">
                    <label for="attributeCategoryDescription" class="from-label">Description</label>
                    <input type="text" name="attributeCategoryDescription" id="attributeCategoryDescription" value="${data["description"]}" placeholder="Attribute Title*" class="form-control" reqiured>
    
                </div>
                <div class="mb-3">
                <label for="attributeCategoryRequired" class="form-label">Required</label>
                
                <select class="form-select" id="attributeCategoryRequired" name="attributeCategoryRequired" aria-label="Default select example">
                <option Value = "1" ${data['is_required'] == 1 ? "selected": ""}>Yes</option>
                <option value="0" ${data['is_required'] == 0 ? "selected": ""}>No</option>
                
                </select>
                </div>
              
    
    
                <div class="button-wrappper">
                <button type="button" id="update" class="btn btn-primary mb-3 me-3" data-id="${data["attribute_categorie_id"]}" >Update</button>
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

  $(document).on("click", "#editFormAttributestCategory #cancel", function () {
    $(this).closest("tr").children("td").removeClass("d-none");
    $(this).closest("td").remove("td");
  });

  $(document).on("click", "#editFormAttributestCategory #update", function () {
    let clickBtn = $(this);
    let categoryData = [];
    categoryData["attributeCategoryId"] = $(this).data("id");
    categoryData["attributeCategoryTitle"] = $("#editFormAttributestCategory #attributeCategoryTitle").val();
    categoryData["attributeCategoryDescription"] = $("#editFormAttributestCategory #attributeCategoryDescription").val();
    categoryData["attributeCategoryRequired"] = $("#editFormAttributestCategory #attributeCategoryRequired").val();


    $(this).attr("disabled", true);

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );

    updateAttributeCategory(categoryData)
      .then(function (data) {
        clickBtn.attr("disabled", false);
        clickBtn.closest("tr").children("td").removeClass("d-none");

        clickBtn
          .closest("tr")
          .find("td .category-name")
          .html(data.title);
        clickBtn
          .closest("tr")
          .find("td.description")
          .html(data.description);
        clickBtn
          .closest("tr")
          .find("td.required")
          .html(data.required);

        $("td.quick-edit-wrapper").remove();
      })
      .catch(function (data) {


        $(".spinner").remove();
        clickBtn.attr("disabled", false);
        $(".errorMessage").remove();
        if (typeof data.error === "object") {
          $.each(data.error, function (field, error) {
            $("#editFormAttributestCategory #" + field).addClass("error");
            $(`<span class=" errorMessage">${error}</span>`).insertAfter(
              "#editFormAttributestCategory #" + field
            );
          });
        } else {
          clickBtn.attr("disabled", false);
          console.error("Error: " + data.error);
          console.log(data);
        }
      });
  });


//  =================== Attributes ========================= //

$(document).on("click", ".edit-wrapper-attributes .quick-edit", function () {
  let clickBtn = $(this);
  let attributeId = $(this).data("id");

  $(this).append(
    "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
  );

  $(this).attr("disabled", true);
  getAttributesDetail(attributeId)
    .then(function (data) {
      clickBtn.attr("disabled", false);

      data = data[0];
   

      let form = ` <td class="quick-edit-wrapper" colspan="5">

      <div class="">
          <form action="http://localhost/richmane/admin/attributes/edit" id="editFormAttributes" autocompleete="off"
           class="row px-3" method="post" accept-charset="utf-8">
              <div id="errorWrapper"></div>
  
              <div class="form-outline mb-4 col-4">
                  <label for="attributeName" class="from-label">Attribute Name</label>
                  <input type="text" name="attributeName" id="attributeName" value="${data["attribute_name"]}" placeholder="Attribute Name*" class="form-control" reqiured>
  
              </div>
        
              <div class="form-outline mb-4 col-4">
                  <label for="attributePrice" class="from-label">Attribute Price</label>
                  <input type="text" name="attributePrice" id="attributePrice" value="${data["price"]}" placeholder="Attribute Pirce*" class="form-control" reqiured>
  
              </div>
              <div class="mb-3 col-6">
              <label for="attributeDesign" class="form-label">Design(col-6/col-12)</label>
              
              <select class="form-select" id="attributeDesign" name="attributeDesign" aria-label="Default select example">
              <option Value = "1" ${data['design_col'] == 1 ? "selected": ""}>Col 6</option>
              <option value="0" ${data['design_col'] == 0 ? "selected": ""}>Col 12</option>
              
              </select>
              </div>
              <div class="mb-3 col-6">
              <label for="attributeModal" class="form-label">Modal</label>
              
              <select class="form-select" id="attributeModal" name="attributeModal" aria-label="Default select example">
              <option Value = "1" ${data['is_modal'] == 1 ? "selected": ""}>Yes</option>
              <option value="0" ${data['is_modal'] == 0 ? "selected": ""}>NO</option>
              
              </select>
              </div>

              <div class="col-lg-12 mb-3">
											<div class="img-upload-wrap">
												 <input type="text" name="oldImage" value="${data['image']}" class="d-none">
												<img class="img-responsive mb-2" id="imagePreview" src="http://localhost/richmane/public/assets/uploads/customize/${data['image']}" alt="upload_img" width="200" height="200">
											</div>
											<div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text">Upload Image</span>
											 
												<input type="file" id="attributeImage" class="upload" name="attributeImage" accept="image/*">
											</div>
										</div>
          
  
  
              <div class="button-wrappper">
              <button type="button" id="update" class="btn btn-primary mb-3 me-3" data-id="${data["attribute_id"]}" >Update</button>
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

$(document).on("click", "#editFormAttributes #cancel", function () {
  $(this).closest("tr").children("td").removeClass("d-none");
  $(this).closest("td").remove("td");
});


$(document).on("click", "#editFormAttributes #update", function () {
  let clickBtn = $(this);
  let attributeData = [];
  attributeData["attributeId"] = $(this).data("id");
  attributeData["attributeName"] = $("#editFormAttributes #attributeName").val();
  attributeData["attributePrice"] = $("#editFormAttributes #attributePrice").val();
  attributeData["attributeDesign"] = $("#editFormAttributes #attributeDesign").val();
  attributeData["attributeModal"] = $("#editFormAttributes #attributeModal").val();

  
  let imageUploaded = $("#editFormAttributes #attributeImage")[0].files[0];


  $(this).attr("disabled", true);

  $(this).append(
    "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
  );
 if (imageUploaded) {
 

    let formData = new FormData();
    formData.append("image", imageUploaded);
    formData.append("location", "public/assets/uploads/customize/");
    uploadImage(formData)
      .then(function (data) {
        attributeData["attributeImage"] = data["imageName"];

        updateAttribute(attributeData)
        .then(function (data) {
          clickBtn.attr("disabled", false);
          clickBtn.closest("tr").children("td").removeClass("d-none");
    
          clickBtn
            .closest("tr")
            .find("td .category-name")
            .html(data.attribute_name);
          clickBtn
            .closest("tr")
            .find("td.price")
            .html(data.price);
    
          $("td.quick-edit-wrapper").remove();
        })
        .catch(function (data) {
    
          $(".spinner").remove();
          clickBtn.attr("disabled", false);
          $(".errorMessage").remove();
          if (typeof data.error === "object") {
            $.each(data.error, function (field, error) {
              $("#editFormAttributes #" + field).addClass("error");
              $(`<span class=" errorMessage">${error}</span>`).insertAfter(
                "#editFormAttributes #" + field
              );
            });
          } else {
            clickBtn.attr("disabled", false);
            console.error("Error: " + data.error);
            console.log(data);
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
            $("#editForm #" + field).addClass("error");
            $(`<span class=" errorMessage">${error}</span>`).insertAfter(
              "#editForm #" + field
            );
          });
        } else {
          console.error("Error: " + data.error);
        }
      });
  }else{
    updateAttribute(attributeData)
    .then(function (data) {
      clickBtn.attr("disabled", false);
      clickBtn.closest("tr").children("td").removeClass("d-none");

      clickBtn
        .closest("tr")
        .find("td .category-name")
        .html(data.attribute_name);
      clickBtn
        .closest("tr")
        .find("td.price")
        .html(data.price);

      $("td.quick-edit-wrapper").remove();
    })
    .catch(function (data) {

      $(".spinner").remove();
      clickBtn.attr("disabled", false);
      $(".errorMessage").remove();
      if (typeof data.error === "object") {
        $.each(data.error, function (field, error) {
          $("#editFormAttributes #" + field).addClass("error");
          $(`<span class=" errorMessage">${error}</span>`).insertAfter(
            "#editFormAttributes #" + field
          );
        });
      } else {
        clickBtn.attr("disabled", false);
        console.error("Error: " + data.error);
        console.log(data);
      }
    });
  }
 
});

  // ============== Delete  Modal ========================= //

  $(document).on(
    "click",
    ".edit-wrapper-categories #deleteConfirm",
    function () {
      let categoryId = $(this).data("id");

      let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
       <p>You Want to Delete This Category Id : ${categoryId}</p>

    </div>

    <!--Footer-->
    <div class="modal-footer flex-center">
      <button type="button" id="confirm"  class="btn btn-danger" data-id="${categoryId}">Yes</button>
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


  // ====================== Delete Category ============================= //

  $(document).on("click", "#modalConfirmDeleteCategory #confirm", function () {
    let catgoryId = $(this).data("id");

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
    $(this).attr("disabled", true);

    deleteCategory(catgoryId)
      .then(function (data) {
        $(".overlay").removeClass("active");
        $(".modal").remove();
        $("#ct" + data.categoryId).remove();

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

  $(document).on("click", "#bulkApplyCategory", function () {
    let action = $("#bulkSelect").val();

    let checkedIds = []; // An array to store the "data-id" values of checked checkboxes

    $('#datable_1 input[type="checkbox"]:checked').each(function () {
      let checkboxId = $(this).data("id");
      checkedIds.push(checkboxId);
    });

    if (action == "delete") {
      let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
    "#modalConfirmDeleteCategory #confirmBulk",
    function () {
      let cateoryIds = $(this).data("id");

      bulkDeleteCategory(cateoryIds)
        .then(function (data) {
          $(".overlay").removeClass("active");
          $(".modal").remove();

          for (let x of data.productIds) {
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
  // =============================  Update product Data ========================================== //

 
  // ==============  Add Categories===================== //
  function addCategory(data) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/add-category",
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

  // ============== Get Product Detail ===================== //
  function getCategoryDetail(categoryId) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "admin/category/" + categoryId,
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

  // ============== Get Product Categories ===================== //
  function getProductCategory() {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "admin/product-category/",
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

  // ============== Update Product Details ===================== //

  function updateCategory(data) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/category",
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

  // ================= Delete Product ======================//

  function deleteCategory(categoryId) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/category/" + categoryId,
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

  function bulkDeleteCategory(categoryIds) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/category/delete",
        type: "POST",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        data: {
          categoryIds: categoryIds,
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


  // ============== Attributest Category Details ====================== //
    function getAttributesCategoryDetail(categoryId) {
      return new Promise(function (resolve, reject) {
        $.ajax({
          url: baseUrl + "admin/attributes-category/" + categoryId,
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


    function updateAttributeCategory(data) {
      return new Promise(function (resolve, reject) {
        $.ajax({
          url: baseUrl + "session/admin/attribute-category",
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
  

    // ============= Attributes ================= //
    function getAttributesDetail(attributeId) {
      return new Promise(function (resolve, reject) {
        $.ajax({
          url: baseUrl + "admin/attributes/" + attributeId,
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

    function updateAttribute(data) {
      return new Promise(function (resolve, reject) {
        $.ajax({
          url: baseUrl + "session/admin/attribute",
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
  


    //  ===================  Reviews =========================

    $(document).on(
      "click",
      ".edit-wrapper-review #deleteConfirm",
      function () {
        let reviewId = $(this).data("id");
  
        let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteReview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
         <p>You Want to Delete This Reviews : ${reviewId}</p>
  
      </div>
  
      <!--Footer-->
      <div class="modal-footer flex-center">
        <button type="button" id="confirm"  class="btn btn-danger" data-id="${reviewId}">Yes</button>
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
  
  
  
    $(document).on("click", "#modalConfirmDeleteReview #confirm", function () {
      let reviewId = $(this).data("id");
  
      $(this).append(
        "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
      );
      $(this).attr("disabled", true);
  
      deleteReview(reviewId)
        .then(function (data) {
          $(".overlay").removeClass("active");
          $(".modal").remove();
          $("#ct" + data.reviewId).remove();
  
          alert("Review is Delete Successfully");
        })
        .catch(function (error) {
          $(".overlay").removeClass("active");
          $(".modal").remove();
          alert(error);
          console.error("Error: " + error);
        });
    });
  
    $(document).on("click", "#bulkApplyReview", function () {
      let action = $("#bulkSelect").val();
  
      let checkedIds = []; // An array to store the "data-id" values of checked checkboxes
  
      $('#datable_1 input[type="checkbox"]:checked').each(function () {
        let checkboxId = $(this).data("id");
        checkedIds.push(checkboxId);
      });
  
      if (action == "delete") {
        let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteReview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
         <p>You Want to Delete This Review  Ids : ${checkedIds}</p>
  
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
      "#modalConfirmDeleteReview #confirmBulk",
      function () {
        let reviewIds = $(this).data("id");
  
        bulkDeleteReview(reviewIds)
          .then(function (data) {
            $(".overlay").removeClass("active");
            $(".modal").remove();
  
            for (let x of data.reviewIds) {
              $("#ct" + x).remove();
            }
  
            alert("Review is Delete Successfully");
          })
          .catch(function (error) {
            $(".overlay").removeClass("active");
            $(".modal").remove();
            alert(error);
            console.error("Error: " + error);
          });
      }
    );

    function deleteReview(reviewId) {
      return new Promise(function (resolve, reject) {
        $.ajax({
          url: baseUrl + "session/admin/review/" + reviewId,
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

    function bulkDeleteReview(reviewIds) {
      return new Promise(function (resolve, reject) {
        $.ajax({
          url: baseUrl + "session/admin/review/delete",
          type: "POST",
          headers: {
            "X-Requested-With": "XMLHttpRequest",
          },
          data: {
            reviewIds: reviewIds,
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




    //  ===================  Inbox =========================


  
  

  
    $(document).on("click", "#bulkApplyInbox", function () {
      let action = $("#bulkSelect").val();
  
      let checkedIds = []; // An array to store the "data-id" values of checked checkboxes
  
      $('.checkbox input[type="checkbox"]:checked').each(function () {
        let checkboxId = $(this).data("id");
        checkedIds.push(checkboxId);
      });
  
      if (action == "delete") {
        let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteInbox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
         <p>You Want to Delete This Emails  Ids : ${checkedIds}</p>
  
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
      "#modalConfirmDeleteInbox #confirmBulk",
      function () {
        let ids = $(this).data("id");
  
        bulkDeleteInbox(ids)
          .then(function (data) {
            $(".overlay").removeClass("active");
            $(".modal").remove();
  
            for (let x of data.ids) {
              $("#ct" + x).remove();
            }
  
            alert("Inbox is Delete Successfully");
          })
          .catch(function (error) {
            $(".overlay").removeClass("active");
            $(".modal").remove();
            alert(error);
            console.error("Error: " + error);
          });
      }
    );

  

    function bulkDeleteInbox(ids) {
      return new Promise(function (resolve, reject) {
        $.ajax({
          url: baseUrl + "session/admin/inbox/delete",
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
