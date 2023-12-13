import { baseUrl } from "./custom.js";
$(document).ready(function () {


  $(document).on('change', '#produtGallery', function(e) {
    var fileInput = e.target;
    var galleryWrapper = $('.product-gallery-wrapper');

    // Check if files are selected
    if (fileInput.files.length > 0) {
        for (var i = 0; i < fileInput.files.length; i++) {
            var file = fileInput.files[i];
            var reader = new FileReader();

            reader.onload = function(e) {
                // Create an image element for each selected file
                var imgElement = $('<img class="gallery-image" width="100" height="100">');
                imgElement.attr('src', e.target.result);

                // Append the image to the gallery wrapper
                galleryWrapper.append(imgElement);
            };

            // Read the selected file as a data URL
            reader.readAsDataURL(file);
        }
    }
});
  $(document).on("click", ".edit-wrapper .quick-edit", function () {
    let clickBtn = $(this);
    let ProductId = $(this).data("id");

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );

    $(this).attr('disabled', true);
    getProductDetail(ProductId)
      .then(function (data) {
        data = data[0];
        clickBtn.attr('disabled', false);


        getProductCategory()
         .then(function(data){
          $('#productCategory').append(data);
        })
        .catch(function(error){
          console.log(error);
        })


        let form = `  <td class="quick-edit-wrapper" colspan="5">

        <div class="">
            <form action="http://localhost/richmane/admin/product/edit" id="editForm" autocompleete="off"
             class="row px-3 editFormAll " method="post" accept-charset="utf-8">
                <div id="errorWrapper"></div>
    
                <div class="form-outline mb-4 col-4">
                    <label for="productName" class="from-label">Name</label>
                    <input type="text" name="productName" id="productName" value="${
                      data["product_name"]
                    }" placeholder="Product Name*" class="form-control" reqiured>
    
                </div>
                <div class="form-outline mb-4 col-4">
                    <label for="slug" class="from-label">Slug</label>
                    <input type="text" name="slug" value="${
                      data["slug"]
                    }" id="slug" placeholder="slug*" class="form-control" reqiured>
    
                </div>
                <div class="form-outline mb-4 col-4">
                    <label for="productCategory" class="from-label">Product Category</label>
                    <select name="productCategory" class="form-select" id="productCategory">
                        <option value="${
                          data["category_id"]
                        }" selected="selected">${data["category_name"]}</option>
                        
    
    
    
                    </select>
    
                </div>
    
                <div class="form-outline mb-4 col-4">
                    <label for="sku" class="from-label">SKU</label>
    
                    <input type="text" name="sku" value="${
                      data["sku"]
                    }" id="sku" placeholder="SKU" class="form-control">
    
                </div>
                <div class="form-outline mb-4 col-4">
                    <label for="price" class="from-label">Price</label>
    
                    <input type="text" name="price" value="${
                      data["price"]
                    }" id="price" placeholder="price*" class="form-control" required>
    
                </div>
                <div class="form-outline mb-4 col-4">
                    <label for="salePrice" class="from-label">Sale Price</label>
    
                    <input type="text" name="salePrice" value="${
                      data["sale_price"]
                    }" id="salePrice" placeholder="sale Price" class="form-control">
    
                </div>
    
                <div class="form-outline mb-4 col-4">
                    <label for="featureProduct" class="from-label">New Product</label>
                    <select name="featureProduct" class="form-select" id="featured">
                        <option value="">Featue Product</option>
                        <option value="1" ${
                          data["featured"] == 1 ? "selected" : ""
                        }>Yes</option>
                        <option value="0" ${
                          data["featured"] == 0 ? "selected" : ""
                        }>No</option>
    
                    </select>
    
                </div>
                <div class="form-outline mb-4 col-4">
                    <label for="stockStatus" class="from-label">Stock Status</label>
                    <select name="stockStatus" class="form-select" id="stockStatus">
                        <option value="">Stock Status</option>
                        <option value="1" ${
                          data["stock_status"] == 1 ? "selected " : ""
                        }">In Stock</option>
                        <option value="0" ${
                          data["stock_status"] == 0 ? "selected " : ""
                        }>Out of Stock</option>
    
                    </select>
    
                </div>

                <div class="form-outline mb-4 col-4">
                <label for="isVisible" class="from-label">Visible</label>
                <select name="isVisible" class="form-select" id="isVisible">
                    <option value="">Slect Visible</option>
                    <option value="1" ${
                      data["is_visible"] == 1 ? "selected " : ""
                    }">Visible</option>
                    <option value="0" ${
                      data["is_visible"] == 0 ? "selected " : ""
                    }>Not Visible</option>

                </select>

            </div>
    
                <div class="d-none">
                <input type="text" name="oldImage" id="oldImage" value="${
                  data["feature_image"]
                }">
               </div>
    
                <div class="form-outline mb-4 col-6">
                <img id="imagePreview" src="/richmane/public/assets/uploads/products/${
                  data["feature_image"]
                }" class="d-block mb-2 text-start" width="150" height="120">
    
                <label for="featureImage" class="from-label pb-2">Feature Image</label>
                   <input type="file" id="featureImage" class="upload" name="featureImage" accept="image/*">
                   <span  id="image"></span>

                 
    
                </div>

            
   
             
    
    
    
    
    
                <div class="button-wrappper">
                <button type="button" id="update" class="btn btn-primary mb-3 me-3" data-id="${
                  data["product_id"]
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

  // ============== Delete Product Modal ========================= //

  $(document).on("click", ".edit-wrapper #deleteConfirm", function () {
    let productId = $(this).data("id");

  let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
       <p>You Want to Delete This Product Id : ${productId}</p>

    </div>

    <!--Footer-->
    <div class="modal-footer flex-center">
      <button type="button" id="confirm"  class="btn btn-danger" data-id="${productId}">Yes</button>
      <button type="button" class="btn border border-2 text-black" id="deleteCancel">No</button>
    </div>
  </div>
  <!--/.Content-->
</div>
</div>`;

    $(".overlay").addClass("active");

    $("body").append(form);
  });

// ====================== Delete Product ============================= //

$(document).on("click", "#modalConfirmDelete #confirm", function(){


  let productId = $(this).data('id');

  deleteProduct(productId)
  .then(function (data) {
    

    $(".overlay").removeClass("active");
    $(".modal").remove();
    $('#pr'+data.productId).remove();

    alert('Product is Delete Successfully');

  })
  .catch(function (error) {

    $(".overlay").removeClass("active");
    $(".modal").remove();
    alert(error);
    console.error("Error: " + error);
  });




});


//  =========================== Delete Product Bulk ====================== //

$(document).on("click", "#bulkApply", function(){

 let action = $('#bulkSelect').val();

 let checkedIds = []; // An array to store the "data-id" values of checked checkboxes

 $('#datable_1 input[type="checkbox"]:checked').each(function() {
     let checkboxId = $(this).data('id');
     checkedIds.push(checkboxId);
 });


 if(action == 'delete'){

 

  let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
       <p>You Want to Delete This Product Ids : ${checkedIds}</p>

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


})


$(document).on("click", "#modalConfirmDelete #confirmBulk", function(){


  let productIds = $(this).data('id');


  bulkDeleteProduct(productIds)
  .then(function (data) {
    

    $(".overlay").removeClass("active");
    $(".modal").remove();



  for (let x of data.productIds) {

    $('#pr' + x).remove();
   
  }

    alert('Product is Delete Successfully');




  })
  .catch(function (error) {

    $(".overlay").removeClass("active");
    $(".modal").remove();
    alert(error);
    console.error("Error: " + error);
  });




});
  // =============================  Update product Data ========================================== //

  $(document).on("click", "#editForm #update", function () {
    let clickBtn = $(this);
    let productData = [];
    productData["productId"] = $(this).data("id");
    productData["productName"] = $("#editForm #productName").val();
    productData["slug"] = $("#editForm #slug").val();
    productData["productCategory"] = $("#editForm #productCategory").val();
    productData["sku"] = $("#editForm #sku").val();
    productData["price"] = $("#editForm #price").val();
    productData["salePrice"] = $("#editForm #salePrice").val();
    productData["featured"] = $("#editForm #featured").val();
    productData["stockStatus"] = $("#editForm #stockStatus").val();
    productData["oldImage"] = $("#editForm #oldImage").val();
    productData["isVisible"] = $("#editForm #isVisible").val();
    productData["featureImage"] = "";

    let imageUploaded = $("#editForm #featureImage")[0].files[0];

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
    $(this).attr('disabled', true);


    if (imageUploaded) {
   

      let formData = new FormData();
      formData.append("image", imageUploaded);
      formData.append("location", "public/assets/uploads/products/");
      uploadImage(formData)
        .then(function (data) {
          productData["featureImage"] = data["imageName"];

          updateProductDetail(productData)
            .then(function (data) {

              clickBtn.attr('disabled', false);
              clickBtn.closest("tr").children("td").removeClass("d-none");

              clickBtn.closest("tr").find('a.product-name').html(data.productName);
              clickBtn.closest("tr").find('td.product-price').html(data.price);
              clickBtn.closest("tr").find('td.product-category').html(data.productCategory);
              clickBtn.closest("tr").find('td a.product-name').attr('href', baseUrl+'admin/edit-product/' + data.slug);
              clickBtn.closest("tr").find('a.btnView').attr('href', baseUrl+'product-details/' + data.slug);


            

         $('td.quick-edit-wrapper').remove();
              $(".spinner").remove();
            })
            .catch(function (data) {
              $(".spinner").remove();
              clickBtn.attr('disabled', false);
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
      updateProductDetail(productData)
      .then(function (data) {

        clickBtn.attr('disabled', false);
        clickBtn.closest("tr").children("td").removeClass("d-none");


             clickBtn.closest("tr").find('a.product-name').html(data.productName);
              clickBtn.closest("tr").find('td.product-price').html(data.price);
              clickBtn.closest("tr").find('td.product-category').html(data.productCategory);
              clickBtn.closest("tr").find('td a.product-name').attr('href', baseUrl+'admin/edit-product/' + data.slug);
              clickBtn.closest("tr").find('a.btnView').attr('href', baseUrl+'product-details/' + data.slug);

              $('td.quick-edit-wrapper').remove();

      })
      .catch(function (data) {
        $(".spinner").remove();
        clickBtn.attr('disabled', false)
        $(".errorMessage").remove();
        if (typeof data.error === "object") {
          $.each(data.error, function (field, error) {
            $("#editForm #" + field).addClass("error");
            $(`<span class=" errorMessage">${error}</span>`).insertAfter(
              "#editForm #" + field
            );
          });
        } else {
          clickBtn.attr('disabled', false);
          console.error("Error: " + data.error);
        }
      });
  
    }


  });

  // =============== Help me chosse male or Female ============= //

  $(document).on('change', '#helpGender', function(){

  
    let gender = $(this).val();
    let productId = $("#productId").val();
   
    let form = '';


    $('#gender-label').append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );

    if(gender == 1){


      getHelpMeChoose(productId, gender)
      .then(function(data){
         
        $('.spinner').remove()
        $('.help-me-chosse-options').html(data);
      })
      .catch(function(error){
        $('.spinner').remove()
        form = `<div class="row">
        <div class="col-sm-4">
          <div class="form-group">
            <label for="helpHairLoss" class="control-label mb-10">Hair Loss Type</label>
            <select class="form-select" id="helpHairLoss" name="helpHairLoss" data-placeholder="Choose a Category" tabindex="1" required>
              <option value="">Choose Hair Loss Type</option>
              <option value="front">Hair Thinning At The Front</option>
              <option value="crown">Hair Thinning At The Crown</option>
              <option value="top">Hair Thinning At The Top</option>
              <option value="increase_top">Increased Hair Thinning At the Top</option>
              <option value="complete">Complete Hair Loss</option>
  
            </select>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label for="helpSweat" class="control-label mb-10">Amount of Sweat (1 to 5)</label>
            <select class="form-select" id="helpSweat" name="helpSweat" data-placeholder="Choose a Category" tabindex="1" required>
              <option value="">Choose Amount of Sweat</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
  
            </select>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label for="helpWorkout" class="control-label mb-10">Workout Habit (1 to 5)</label>
            <select class="form-select" id="helpWorkout" name="helpWorkout" data-placeholder="Choose a Category" tabindex="1" required>
              <option value="">Choose Amount of Workout</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
  
            </select>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label for="helpQuiff" class="control-label mb-10">Hair Style Quiff or Brush back</label>
            <select class="form-select" id="helpQuiff" name="helpQuiff" data-placeholder="Choose a Category" tabindex="1" required>
              <option value="">Choose Quiff or Brush back</option>
              <option value="1">Yes</option>
              <option value="0">NO</option>
  
  
            </select>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label for="helpHairColor" class="control-label mb-10">Hair Color</label>
            <select class="form-select" id="helpHairColor" name="helpHairColor" data-placeholder="Choose a Category" tabindex="1" required>
              <option value="">Choose Hair Color</option>
              <option value="dark">Dark</option>
              <option value="brown">Brown</option>
              <option value="blonde">Blonde</option>
              <option value="grey">Grey</option>
  
            </select>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label for="helpHairDensity" class="control-label mb-10">Hair Density</label>
            <select class="form-select" id="helpHairDensity" name="helpHairDensity" data-placeholder="Choose a Category" tabindex="1" required>
              <option value="">Choose Hair Desity</option>
              <option value="60">Extra Light 60%</option>
              <option value="80">Light 80%</option>
              <option value="100">Medium Light 100%(Suits most people)</option>
              <option value="120">Medium Light 120%</option>
              <option value="140">Medium Heavy 140%</option>
  
            </select>
          </div>
        </div>
  
  
      </div>`;
      $('.help-me-chosse-options').html(form);
      })

    
    }else if(gender == 2){


      getHelpMeChoose(productId, gender)
      .then(function(data){
         
        $('.spinner').remove()
        $('.help-me-chosse-options').html(data);
      })
      .catch(function(error){
        $('.spinner').remove()
        form = `<div class="col-sm-4">
        <div class="form-group">
          <label for="helphairWig" class="control-label mb-10">Hair wig Product</label>
          <select class="form-select" id="helphairWig" name="helpHairWig" data-placeholder="Choose a Category" tabindex="1" required>
            <option value="">Choose Hair Wig Product</option>
            <option value="topper">Topper</option>
            <option value="fullCap">Full Cap</option>
            <option value="extensions">Extensions</option>
            <option value="integration">Integration</option>
  
  
          </select>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label for="helpattachmentMethod" class="control-label mb-10">Attachment method</label>
          <select class="form-select" id="helpattachmentMethod" name="helpAttachmentMethod" data-placeholder="Choose a Category" tabindex="1" required>
            <option value="">Choose Attachment method</option>
            <option value="clip">Clips (Suitable for minimal hair thinning)</option>
            <option value="glue">Glue/Tape (Suitable for major hair thinning)</option>
  
  
  
          </select>
        </div>
      </div>
  
      <div class="col-sm-4">
        <div class="form-group">
          <label for="helpHairColor" class="control-label mb-10">Hair Color</label>
          <select class="form-select" id="helpHairColor" name="helpHairColor" data-placeholder="Choose a Category" tabindex="1" required>
            <option value="">Choose Hair Color</option>
            <option value="dark" >Dark</option>
            <option value="brown" >Brown</option>
            <option value="blonde">Blonde</option>
            <option value="reddish">Reddish</option>
  
          </select>
        </div>
      </div>`;
      $('.help-me-chosse-options').html(form);
      })
    }else{

      $('.spinner').remove();
      $('.help-me-chosse-options').html('<div></div>');
      
    }




  })

  // ===================== attributes  ================== //
  $(document).on('click', '#attributeCategoryWrapper input', function(){

     let attributeCategoryName = $(this).data('category');


     if($(this).is(':checked')){
         
    
     getAttribute(attributeCategoryName)
     .then(function (data) {


  $('.product-attributes-category ').after(data);

   

  if(attributeCategoryName == 'hairColor' || attributeCategoryName == 'curl'){

    let productGender =  $('#productGender').val();
 

    if(productGender == 'men'){
      $('#attrWomen').closest('.form-check').remove();
    
  
    }else if(productGender == 'women'){
    
      $('#attrMen').closest('.form-check').remove();
    
    }
  }

 

     })
     .catch(function (error) {
     
       console.error("Error: " + error);
     });
     }else{
    
      
      $('#adata'+attributeCategoryName).remove();
     }


  });

  $(document).on('click', '#adatahairColor input', function(){

    let attributeCategoryName = '';

    if($(this).is(':checked')){
  

   
      if($(this).val() == 44){
        attributeCategoryName = 'hairColorMen'
        
      }else if($(this).val() == 45){
        attributeCategoryName = 'hairColorWomen'
      }else{
        return;
      }

    getAttribute(attributeCategoryName)
    .then(function (data) {

  
     $('.product-attributes-category ').after(data);
    })
    .catch(function (error) {
    
      console.error("Error: " + error);
    });
    }else{

      if($(this).val() == 44){
        attributeCategoryName = 'hairColorMen'
        
      }else if($(this).val() == 45){
        attributeCategoryName = 'hairColorWomen'
      }else{
        return;
      }
    //  console.log('unChecked' + attributeCategoryName);

     $('[id^="adata'+attributeCategoryName+'"]').remove();
     
  
    }


 });
  $(document).on('click', '#adatacurl input', function(){

    let attributeCategoryName = '';

    if($(this).is(':checked')){
      if($(this).val() == 30){
        attributeCategoryName = 'curlMen'
        
      }else if($(this).val() == 31){
        attributeCategoryName = 'curlWomen'
      }else{
        return;
      }

    getAttribute(attributeCategoryName)
    .then(function (data) {
      $('.product-attributes-category ').after(data);

    })
    .catch(function (error) {
    
      console.error("Error: " + error);
    });
    }else{

      if($(this).val() == 30){
        attributeCategoryName = 'curlMen'
        
      }else if($(this).val() == 31){
        attributeCategoryName = 'curlWomen'
      }else{
        return;
      }
     $('#adata'+attributeCategoryName).remove();
     
  
    }


 });
  $(document).on('click', '#adatagreyHair input', function(){

    let attributeCategoryName = '';

    if($(this).is(':checked')){
      if($(this).val() == 57){
        attributeCategoryName = 'greyHairType'
      }else{
        return;
      }
    getAttribute(attributeCategoryName)
    .then(function (data) {
      $('.product-attributes-category ').after(data);
    })
    .catch(function (error) {
    
      console.error("Error: " + error);
    });
    }else{

      if($(this).val() == 57){
        attributeCategoryName = 'greyHairType'
        
      }else{
        return;
      }
     $('#adata'+attributeCategoryName).remove();
     
  
    }


 });

 $(document).on('click', '#adatamenHairCut input', function(){
  let attributeCategoryName = 'hairStyleMen'
  if($(this).is(':checked')){
  getAttribute(attributeCategoryName)
  .then(function (data) {
$('.product-attributes-category ').after(data);
  })
  .catch(function (error) {
  
    console.error("Error: " + error);
  });
  }else{
   $('#adata'+attributeCategoryName).remove();
  }
});
 $(document).on('click', '#adatawomenHairCut input', function(){

  
  let attributeCategoryName = 'hairStyleWomen'
  if($(this).is(':checked')){
  getAttribute(attributeCategoryName)
  .then(function (data) {
$('.product-attributes-category ').after(data);
  })
   .catch(function (error) {
    console.error("Error: " + error);
  });
  }else{
   $('#adata'+attributeCategoryName).remove();
  }


});

$(document).on('click', '#adataperm input', function(){

  let attributeCategoryName = '';

  if($(this).is(':checked')){
    if($(this).val() == 143){
      attributeCategoryName = 'permYes'
    }else{
      return;
    }
  getAttribute(attributeCategoryName)
  .then(function (data) {
    $('.product-attributes-category ').after(data);
  })
  .catch(function (error) {
  
    console.error("Error: " + error);
  });
  }else{

    if($(this).val() == 143){
      attributeCategoryName = 'permYes'
      
    }else{
      return;
    }
   $('#adata'+attributeCategoryName).remove();
   

  }


});

  $(document).on('click', '.product-gallery-image-wrapper #deleteImage', function(){


    let imageId = $(this).data('id');
    let imageName = $(this).data('name');
    let clickBtn = $(this);
    $(this).attr('disabled',true);
    $(this).html("<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    )

    deleteProductImage(imageId, imageName)
    .then(function (data) {
      
 
      clickBtn.parent('.product-gallery-image-wrapper').remove();
      
  
   
    })
    .catch(function (error) {
  
      console.error("Error: " + error);
    });
  
    



  })

  // =================== Add new Coupon ====================

  $(document).on("click", "button#addNewCoupon", function () {

    let form = `
  
    <div class="modal fade in d-block modal-height-100" id="addNewCoupon" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
        <div class="modal-dialog  modal-notify modal-danger" role="document">
            <!--Content-->
            <div class="modal-content text-center">
                <!--Header-->
                <div class="modal-header d-flex justify-content-center">
                    <p class="heading">Add New Coupon</p>
                </div>
                <div id="#errorWrapper"> </div>
                <!--Body-->
                <div class="modal-body">
                    <form class="row">
                        <div class="mb-3">
                            <label for="couponCode" class="form-label">Coupon Code*</label>
                            <input type="text" class="form-control" id="couponCode" aria-describedby="couponCode" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="discountValue" class="form-label">Discount Value*</label>
                            <input type="text" class="form-control" id="discountValue" aria-describedby="discountValue" required>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="parentCategory" class="form-label">Discount Type*</label>

                            <select class="form-select" id="discountType" name="discountType" aria-label="Default select example" required>
                                <option selected>Selecte Discount Type</option>
                                <option value="1">Percentage</option>
                                <option value="2">Fixed Value</option>

                            </select>
                        </div>

                        <div class="mb-3 col-6">
                            <label for="minPurchase" class="form-label">Min Purchase*</label>
                            <div class="d-flex align-items-center input-dollar-wrapper">
                                <input type="text" class="form-control" id="minPurchase" aria-describedby="discountValue" required>
                                <span class="input-dollar">$</span>
                            </div>
                        </div>

                        <div class="mb-3 col-6">
                            <label for="maxDiscount" class="form-label">Max Discount*</label>
                            <div class="d-flex algin-items-center input-dollar-wrapper">
                                <input type="text" class="form-control" id="maxDiscount" aria-describedby="discountValue">
                                <span class="input-dollar">$</span>
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="startDate" class="form-label">Coupon Start Date*</label>
                            <input type="date" class="form-control" id="startDate" aria-describedby="startDate">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="endDate" class="form-label">Coupon Expire Date*</label>
                            <input type="date" class="form-control" id="endDate" aria-describedby="startDate">
                        </div>
                        <div class="mb-3 col-12">
                            <label for="couponUsed" class="form-label">No of Time Coupon Used (By single User)*</label>
                            <input type="text" class="form-control" id="couponUsed" aria-describedby="discountValue">
                        </div>
                        <div class="mb-3 col-12">
                            <label for="endDate" class="form-label d-block">Description</label>
                            <textarea row="4" class="w-100" id="description"></textarea>
                        </div>



                </div>

                <!--Footer-->
                <div class="modal-footer flex-center">
                    <button type="button" id="add" class="btn btn-primary">Save</button>
                    <button type="button" class="btn border border-2 text-black" id="modalClose">Close</button>
                </div>
                </form>
            </div>
            <!--/.Content-->
        </div>
    </div>`;

    $(".overlay").addClass("active");
    $("body").addClass("active");

    $("body").append(form);
  });

  $(document).on("click", "#addNewCoupon #add", function () {
    let data = [];
    let clickBtn = $(this);
    data["couponCode"] = $("#addNewCoupon #couponCode").val();
    data["discountValue"] = $("#addNewCoupon #discountValue").val();
    data["discountType"] = $("#addNewCoupon #discountType").val();
    data["minPurchase"] = $("#addNewCoupon #minPurchase").val();
    data["maxDiscount"] = $("#addNewCoupon #maxDiscount").val();
    data["startDate"] = $("#addNewCoupon #startDate").val();
    data["endDate"] = $("#addNewCoupon #endDate").val();
    data["couponUsed"] = $("#addNewCoupon #couponUsed").val();
    data["description"] = $("#addNewCoupon #description").val();

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );

    addCoupon(data)
      .then(function (data) {

      
        let form = `<tr role="row" class="even" id="ct${data.id}">
    <td>
        <input class="form-check-input" type="checkbox" name="checkbox" data-id="${data.id}">
    </td>


    <td><span class="coupon-code">${data.couponCode}</span>

        <div class=" edit-wrapper-all edit-wrapper-coupon d-flex g-2 pt-2">
            <button type="btn" class="btn text-black ">ID: ${data.id}</button>
            <button type="button" class="btn text-black quick-edit" data-id="${data.id}">Quick Edit</button>
            <button type="button" class="btn text-danger " id="deleteConfirm" data-id="${data.id}">Delete</button>
            
        </div>

    </td>
    <td class="sorting_1 discount_value"> ${data.discountValue}  ${data.discountType == 1 ? "%": "Fixed Price"} </td>
     <td class="max-discount"> ${data.maxDiscount}</td>
    <td class="start-date">${data.startDate}</td>
    <td class="end-date">${data.endDate}</td>
    <td class="active">${data.active == 1 ? "Active" : "In Active"}</td>

</tr>`;

        $("#datable_1 tbody").prepend(form);

        $(".modal").remove();
        $(".overlay").removeClass("active");
        

        alert("Successfuly Coupon Added");
      })
      .catch(function (data) {
        $('.spinner').remove()
        clickBtn.attr("disabled", false);

        if (typeof data.error === "object") {
          $.each(data.error, function (field, error) {
            $("#addNewCoupon #" + field).addClass("error");
            $(`<span class=" errorMessage">${error}</span>`).insertAfter(
              "#addNewCoupon #" + field
            );
          });
        } else {
          console.error("Error: " + data.error);
          console.log(data)
        }
      });
  });

  $(document).on("click", ".edit-wrapper-coupon .quick-edit", function () {
    let clickBtn = $(this);
    let couponId = $(this).data("id");

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );

    $(this).attr("disabled", true);
    getCouponDetail(couponId)
      .then(function (data) {
        clickBtn.attr("disabled", false);

        data = data[0];
   

        let form = `  <td class="quick-edit-wrapper" colspan="7">

        <div class="">
            <form action="http://localhost/richmane/admin/coupon/edit" id="editFormCoupon"  autocompleete="off"
             class="row px-3 editFormAll" method="post" accept-charset="utf-8">
                <div id="errorWrapper"></div>
    
                <div class="mb-3">
                <label for="couponCode" class="form-label">Coupon Code*</label>
                <input type="text" class="form-control" id="couponCode" value="${data["coupon_code"]}" aria-describedby="couponCode" required>
            </div>
            <div class="mb-3 col-6">
                <label for="discountValue" class="form-label">Discount Value*</label>
                <input type="text" class="form-control" id="discountValue" value="${data["discount_value"]}" aria-describedby="discountValue" required>
            </div>
            <div class="mb-3 col-6">
                <label for="parentCategory" class="form-label">Discount Type*</label>

                <select class="form-select" id="discountType" name="discountType" aria-label="Default select example" required>
                    <option selected>Selecte Discount Type</option>
                    <option value="1" ${data["discount_type"] == 1 ? "selected": ""}>Percentage</option>
                    <option value="2" ${data["discount_type"] == 2 ? "selected": ""}>Fixed Value</option>

                </select>
            </div>

            <div class="mb-3 col-6">
                <label for="minPurchase" class="form-label">Min Purchase*</label>
                <div class="d-flex align-items-center input-dollar-wrapper">
                    <input type="text" class="form-control" id="minPurchase" value="${data["min_purchase"]}" aria-describedby="discountValue" required>
                    <span class="input-dollar">$</span>
                </div>
            </div>

            <div class="mb-3 col-6">
                <label for="maxDiscount" class="form-label">Max Discount*</label>
                <div class="d-flex algin-items-center input-dollar-wrapper">
                    <input type="text" class="form-control" id="maxDiscount" value="${data["max_discount"]}" aria-describedby="discountValue">
                    <span class="input-dollar">$</span>
                </div>
            </div>
            <div class="mb-3 col-6">
                <label for="startDate" class="form-label">Coupon Start Date*</label>
                <input type="date" value="${data["start_date"]}" class="form-control" id="startDate" aria-describedby="startDate">
            </div>
            <div class="mb-3 col-6">
                <label for="endDate" class="form-label">Coupon Expire Date*</label>
                <input type="date" value="${data["end_date"]}" class="form-control" id="endDate" aria-describedby="startDate">
            </div>
            <div class="mb-3 col-12">
                <label for="couponUsed" class="form-label">No of Time Coupon Used (By single User)*</label>
                <input type="text" value="${data["coupon_used"]}" class="form-control" id="couponUsed" aria-describedby="discountValue">
            </div>
            <div class="mb-3 col-12">
                <label for="endDate" class="form-label d-block">Description</label>
                <textarea row="4" class="w-100" id="description">${data["description"]}</textarea>
            </div>
            <div class="mb-3 col-12">
            <label for="active" class="form-label">Discount Type*</label>

            <select class="form-select" id="active" name="active" aria-label="Default select example" required>
                <option selected>Selecte Coupon Active</option>
                <option value="1" ${data["is_active"] == 1 ? "selected": ""}>Active</option>
                <option value="0" ${data["is_active"] == 0 ? "selected": ""}>In Active</option>

            </select>
        </div>

          
          
    
    
                <div class="button-wrappper">
                <button type="button" id="update" class="btn btn-primary mb-3 me-3" data-id="${data["coupon_id"]}" >Update</button>
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


  $(document).on("click", "#editFormCoupon #update", function () {
    let clickBtn = $(this);
    let data = [];
    data["couponId"] = $(this).data('id');
    data["couponCode"] = $("#editFormCoupon #couponCode").val();
    data["discountValue"] = $("#editFormCoupon #discountValue").val();
    data["discountType"] = $("#editFormCoupon #discountType").val();
    data["minPurchase"] = $("#editFormCoupon #minPurchase").val();
    data["maxDiscount"] = $("#editFormCoupon #maxDiscount").val();
    data["startDate"] = $("#editFormCoupon #startDate").val();
    data["endDate"] = $("#editFormCoupon #endDate").val();
    data["couponUsed"] = $("#editFormCoupon #couponUsed").val();
    data["description"] = $("#editFormCoupon #description").val();
    data["active"] = $("#editFormCoupon #active").val();



    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
    $(this).attr('disabled', true);

            
      updateCouponDetail(data)
      .then(function (data) {

        clickBtn.attr('disabled', false);
        clickBtn.closest("tr").children("td").removeClass("d-none");


             clickBtn.closest("tr").find('span.coupon-code').html(data.couponCode);
              clickBtn.closest("tr").find('td.discount_value').html(data.discountValue );
              clickBtn.closest("tr").find('td.max-discount').html(data.maxDiscount);
              clickBtn.closest("tr").find('td.start-date').html(data.startDate);
              clickBtn.closest("tr").find('td.end-date').html(data.endDate);
              clickBtn.closest("tr").find('td.active').html(data.active);
            


              $('td.quick-edit-wrapper').remove();

      })
      .catch(function (data) {
        $(".spinner").remove();
        clickBtn.attr('disabled', false)
        $(".errorMessage").remove();
        if (typeof data.error === "object") {
          $.each(data.error, function (field, error) {
            $("#editFormCoupon #" + field).addClass("error");
            $(`<span class=" errorMessage">${error}</span>`).insertAfter(
              "#editFormCoupon #" + field
            );
          });
        } else {
          clickBtn.attr('disabled', false);
          console.error("Error: " + data.error);
        }
      });
  



  });

  $(document).on(
    "click",
    ".edit-wrapper-coupon #deleteConfirm",
    function () {
      let couponId = $(this).data("id");

      let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteCoupon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
       <p>You Want to Delete This Coupon Id : ${couponId}</p>

    </div>

    <!--Footer-->
    <div class="modal-footer flex-center">
      <button type="button" id="confirm"  class="btn btn-danger" data-id="${couponId}">Yes</button>
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



  $(document).on("click", "#modalConfirmDeleteCoupon #confirm", function () {
    let couponId = $(this).data("id");

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
    $(this).attr("disabled", true);

    deleteCoupon(couponId)
      .then(function (data) {
        $(".overlay").removeClass("active");
        $(".modal").remove();
        $("#ct" + data.couponId).remove();

        alert("Coupon is Delete Successfully");
      })
      .catch(function (error) {
        $(".overlay").removeClass("active");
        $(".modal").remove();
        alert(error);
        console.error("Error: " + error);
      });
  });


  $(document).on("click", "#bulkApplyCoupon", function () {
    let action = $("#bulkSelect").val();

    let checkedIds = []; // An array to store the "data-id" values of checked checkboxes

    $('#datable_1 input[type="checkbox"]:checked').each(function () {
      let checkboxId = $(this).data("id");
      checkedIds.push(checkboxId);
    });

    if (action == "delete") {
      let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteCoupon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
       <p>You Want to Delete This Coupon  Ids : ${checkedIds}</p>

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
    "#modalConfirmDeleteCoupon #confirmBulk",
    function () {
      let couponIds = $(this).data("id");


      $(this).attr('disabled', true);
      
    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
      bulkDeleteCoupon(couponIds)
        .then(function (data) {
          $(".overlay").removeClass("active");
          $(".modal").remove();

          for (let x of data.productIds) {
            $("#ct" + x).remove();
          }

          alert("coupon is Delete Successfully");
        })
        .catch(function (error) {
          $(".overlay").removeClass("active");
          $(".modal").remove();
          alert(error);
          console.error("Error: " + error);
        });
    }
  );


  // ========================= Colors ========================== //

  
  $(document).on("click", "button#addNewColor", function () {

    let form = `
  
    <div class="modal fade in d-block " id="addNewColor" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
    <div class="modal-dialog  modal-notify modal-danger" role="document">
        <!--Content-->
        <div class="modal-content text-center">
            <!--Header-->
            <div class="modal-header d-flex justify-content-center">
                <p class="heading">Add New Color</p>
            </div>
            <div id="#errorWrapper"> </div>
            <!--Body-->
            <div class="modal-body">
                <form class="row">
                    <div class="mb-3">
                        <label for="colorName" class="form-label">Color Name*</label>
                        <input type="text" class="form-control" id="colorName" aria-describedby="colorName" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="parentCategory" class="form-label">Gender*</label>

                        <select class="form-select" id="gender" name="gender" aria-label="Default select example" required>
                            <option selected>Selecte Gender</option>
                            <option value="hairColorMen">Male</option>
                            <option value="hairColorWomen">Female</option>

                        </select>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="colorCategorie" class="form-label">Color Category*</label>

                        <select class="form-select" id="colorCategorie" name="colorCategorie" aria-label="Default select example" required>
                            <option selected>Selecte Category</option>
                            <option value="dark">Dark</option>
                            <option value="brown">Brown</option>
                            <option value="blonde">Blonde</option>
                            <option value="gray">Gray</option>
                            <option value="redish">Redish</option>

                        </select>
                    </div>

                    <div class="col-lg-12 text-start">
                        <div class="img-upload-wrap">
                            <img class="img-responsive mb-2 d-none" id="imagePreview" src="" alt="upload_img" width="200" height="200">
                        </div>
                        <div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text">Upload Image</span>

                            <input type="file" id="colorImage" class="upload" name="colorImage" accept="image/*">
                        </div>
                    </div>

            </div>

            <!--Footer-->
            <div class="modal-footer flex-center">
                <button type="button" id="add" class="btn btn-primary">Save</button>
                <button type="button" class="btn border border-2 text-black" id="modalClose">Close</button>
            </div>
            </form>
        </div>
        <!--/.Content-->
    </div>
</div>`;

    $(".overlay").addClass("active");
    $("body").addClass("active");

    $("body").append(form);
  });


  $(document).on("click", "#addNewColor #add", function () {
    let clickBtn = $(this);
    let colorData = [];
    colorData["colorName"] = $("#addNewColor #colorName").val();
    colorData["gender"] = $("#addNewColor #gender").val();
    colorData["colorCategorie"] = $("#addNewColor #colorCategorie").val();
    colorData["colorImage"] = ''
  

    let imageUploaded = $("#addNewColor #colorImage")[0].files[0];

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
    $(this).attr('disabled', true);


    if (imageUploaded) {
     

      let formData = new FormData();
      formData.append("image", imageUploaded);
      formData.append("location", "public/assets/uploads/hair-shades/");
      uploadImage(formData)
        .then(function (data) {
          colorData["colorImage"] = data["imageName"];
       

          addColor(colorData)

            .then(function (data) {

            
        let form = `<tr role="row" class="even" id="ct${data.id}">
        <td>
            <input class="form-check-input" type="checkbox" name="checkbox" data-id="${data.id}">
        </td>
    
    
        <td><span class="color-name">${data.colorName}</span>
    
            <div class=" edit-wrapper-all edit-wrapper-color d-flex g-2 pt-2">
                <button type="btn" class="btn text-black ">ID: ${data.id}</button>
                <button type="button" class="btn text-black quick-edit" data-id="${data.id}">Quick Edit</button>
                <button type="button" class="btn text-danger " id="deleteConfirm" data-id="${data.id}">Delete</button>
                
            </div>
    
        </td>
        <td class="sorting_1 color-category"> ${data.colorCategorie}</td>
       <td class="attribute-category">${data.gender}</td>
       <td class="created-at">${data.createdAt}></td>
    
        </tr>`;
    
            $("#datable_1 tbody").prepend(form);
    
            $(".modal").remove();
            $(".overlay").removeClass("active");
            $("body").removeClass("active");
            
    
            alert("Successfuly Color Added");
            })
            .catch(function (data) {

              $("body").removeClass("active");
              $(".spinner").remove();
              clickBtn.attr('disabled', false);
              $(".errorMessage").remove();
              if (typeof data.error === "object") {
                $.each(data.error, function (field, error) {
                  $("#addNewColor #" + field).addClass("error");
                  $(`<span class=" errorMessage">${error}</span>`).insertAfter(
                    "#addNewColor #" + field
                  );
                });
                
              } else {
              
                console.error("Error: " + data.error);
                console.log(data)
              }
            });
        })
        .catch(function (data) {
          $("body").removeClass("active");
          $(".overlay").removeClass("active");
          clickBtn.attr('disabled', false);
          $(".spinner").remove();
          $(this).attr('disabled', false);
          $(".errorMessage").remove();

          console.log(data);
        });
    }else{
     
      clickBtn.attr('disabled', false)
      $('.spinner').remove()
      alert('Image is required');
    }

  });

  $(document).on("click", ".edit-wrapper-color .quick-edit", function () {
    let clickBtn = $(this);
    let colorId = $(this).data("id");

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );

    $(this).attr("disabled", true);
    getColorDetail(colorId)
      .then(function (data) {
        clickBtn.attr("disabled", false);

        data = data[0];
   

        let form = `  <td class="quick-edit-wrapper" colspan="7">

        <div class="">
            <form action="http://localhost/richmane/admin/coupon/edit" id="editFormColor"  autocompleete="off"
             class="row px-3 editFormAll" method="post" accept-charset="utf-8">
                <div id="errorWrapper"></div>
    
                <div class="mb-3">
                <label for="colorName" class="form-label">Color Name*</label>
                <input type="text" class="form-control" id="colorName" value="${data.attribute_name}" aria-describedby="colorName" required>
            </div>
            <div class="mb-3 col-6">
                <label for="parentCategory" class="form-label">Gender*</label>

                <select class="form-select" id="gender" name="gender" aria-label="Default select example" required>
                    <option selected>Selecte Gender</option>
                    <option value="hairColorMen" ${data.attribute_categorie == "hairColorMen"? "selected": ""}>Male</option>
                    <option value="hairColorWomen"  ${data.attribute_categorie == "hairColorWomen"? "selected": ""}>Female</option>

                </select>
            </div>
            <div class="mb-3 col-6">
                <label for="colorCategorie" class="form-label">Color Categorie*</label>

                <select class="form-select" id="colorCategorie" name="colorCategorie" aria-label="Default select example" required>
                    <option selected>Selecte Categorie</option>
                    <option value="dark" ${data.color_categorie == "dark"? "selected": ""}>Dark</option>
                    <option value="brown" ${data.color_categorie == "brown"? "selected": ""}>Brown</option>
                    <option value="blonde" ${data.color_categorie == "blonde"? "selected": ""}>Blonde</option>
                    <option value="gray" ${data.color_categorie == "gray"? "selected": ""}>Gray</option>
                    <option value="redish" ${data.color_categorie == "redish"? "selected": ""}>Redish</option>

                </select>
            </div>

            <div class="col-lg-12 text-start mb-2">
                        <div class="img-upload-wrap">
                            <img class="img-responsive mb-2 ${data.image != '' ? '': 'd-none'}" id="imagePreview" src="${baseUrl+'public/assets/uploads/hair-shades/'}${data.image}" alt="upload_img" width="200" height="200">
                        </div>
                        <div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text">Upload Image</span>

                            <input type="file" id="colorImage" class="upload" name="colorImage" accept="image/*">
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


  $(document).on("click", "#editFormColor #update", function () {
    let clickBtn = $(this);
    let colorData = [];
    colorData["colorId"] = $(this).data('id');
    colorData["colorName"] = $("#editFormColor #colorName").val();
    colorData["gender"] = $("#editFormColor #gender").val();
    colorData["colorCategorie"] = $("#editFormColor #colorCategorie").val();


    let imageUploaded = $("#editFormColor #colorImage")[0].files[0];

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
    $(this).attr('disabled', true);


    if(imageUploaded){
      let formData = new FormData();
      formData.append("image", imageUploaded);
      formData.append("location", "public/assets/uploads/hair-shades/");
      uploadImage(formData)
        .then(function (data) {
          colorData["colorImage"] = data["imageName"];


          updateColorDetail(colorData)
          .then(function (data) {
    
            clickBtn.attr('disabled', false);
            clickBtn.closest("tr").children("td").removeClass("d-none");
    
    
                 clickBtn.closest("tr").find('span.color-name').html(data.colorName);
                  clickBtn.closest("tr").find('td.attribute-category').html(data.gender );
                  clickBtn.closest("tr").find('td.color-category').html(data.colorCategory);
                 
                  $('td.quick-edit-wrapper').remove();
    
          })
          .catch(function (data) {
            $(".spinner").remove();
            clickBtn.attr('disabled', false)
            $(".errorMessage").remove();
            if (typeof data.error === "object") {
              $.each(data.error, function (field, error) {
                $("#editFormColor #" + field).addClass("error");
                $(`<span class=" errorMessage">${error}</span>`).insertAfter(
                  "#editFormColor #" + field
                );
              });
            } else {
              clickBtn.attr('disabled', false);
              console.error("Error: " + data.error);
            }
          });
          }) .catch(function (data) {
                $("body").removeClass("active");
                 $(".overlay").removeClass("active");
                 clickBtn.attr('disabled', false);
              $(".spinner").remove();
               $(this).attr('disabled', false);
               $(".errorMessage").remove();

               console.log(data);
     
                });
            
              }else{
                updateColorDetail(colorData)
                .then(function (data) {
          
                  clickBtn.attr('disabled', false);
                  clickBtn.closest("tr").children("td").removeClass("d-none");
          
          
                       clickBtn.closest("tr").find('span.color-name').html(data.colorName);
                        clickBtn.closest("tr").find('td.attribute-category').html(data.gender );
                        clickBtn.closest("tr").find('td.color-category').html(data.colorCategory);
                       
                        $('td.quick-edit-wrapper').remove();
          
                })
                .catch(function (data) {
                  $(".spinner").remove();
                  clickBtn.attr('disabled', false)
                  $(".errorMessage").remove();
                  if (typeof data.error === "object") {
                    $.each(data.error, function (field, error) {
                      $("#editFormColor #" + field).addClass("error");
                      $(`<span class=" errorMessage">${error}</span>`).insertAfter(
                        "#editFormColor #" + field
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
    ".edit-wrapper-color #deleteConfirm",
    function () {
      let colorId = $(this).data("id");

      let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteColor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
       <p>You Want to Delete This Color Id : ${colorId}</p>

    </div>

    <!--Footer-->
    <div class="modal-footer flex-center">
      <button type="button" id="confirm"  class="btn btn-danger" data-id="${colorId}">Yes</button>
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


  $(document).on("click", "#modalConfirmDeleteColor #confirm", function () {
    let colorId = $(this).data("id");

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
    $(this).attr("disabled", true);

    deleteColor(colorId)
      .then(function (data) {
        $(".overlay").removeClass("active");
        $(".modal").remove();
        $("#ct" + data.colorId).remove();

        alert("Color is Delete Successfully");
      })
      .catch(function (error) {
        $(".overlay").removeClass("active");
        $(".modal").remove();
        alert(error);
        console.error("Error: " + error);
      });
  });


  $(document).on("click", "#bulkApplyColor", function () {
    let action = $("#bulkSelect").val();

    let checkedIds = []; // An array to store the "data-id" values of checked checkboxes

    $('#datable_1 input[type="checkbox"]:checked').each(function () {
      let checkboxId = $(this).data("id");
      checkedIds.push(checkboxId);
    });

    if (action == "delete") {
      let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteColor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
       <p>You Want to Delete This Color  Ids : ${checkedIds}</p>

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
    "#modalConfirmDeleteColor #confirmBulk",
    function () {
      let colorIds = $(this).data("id");


      $(this).attr('disabled', true);
      
    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
      bulkDeleteColor(colorIds)
        .then(function (data) {
          $(".overlay").removeClass("active");
          $(".modal").remove();

          for (let x of data.colorIds) {
            $("#ct" + x).remove();
          }

          alert("Color is Delete Successfully");
        })
        .catch(function (error) {
          $(".overlay").removeClass("active");
          $(".modal").remove();
          alert(error);
          console.error("Error: " + error);
        });
    });



     // ========================= hair Style ========================== //

  
  $(document).on("click", "button#addNewHairStyle", function () {

    let form = `
  
    <div class="modal fade in d-block " id="addNewHairStyle" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
    <div class="modal-dialog  modal-notify modal-danger" role="document">
        <!--Content-->
        <div class="modal-content text-center">
            <!--Header-->
            <div class="modal-header d-flex justify-content-center">
                <p class="heading">Add New Color</p>
            </div>
            <div id="#errorWrapper"> </div>
            <!--Body-->
            <div class="modal-body">
                <form class="row">
                    <div class="mb-3">
                        <label for="hairName" class="form-label">Style Name*</label>
                        <input type="text" class="form-control" id="hairName" aria-describedby="hairName" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="parentCategory" class="form-label">Gender*</label>

                        <select class="form-select" id="gender" name="gender" aria-label="Default select example" required>
                            <option selected>Selecte Gender</option>
                            <option value="hairStyleMen">Male</option>
                            <option value="hairStyleWomen">Female</option>

                        </select>
                    </div>
             

                    <div class="col-lg-12 text-start">
                        <div class="img-upload-wrap">
                            <img class="img-responsive mb-2 d-none" id="imagePreview" src="" alt="upload_img" width="200" height="200">
                        </div>
                        <div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text">Upload Image</span>

                            <input type="file" id="hairStyleImage" class="upload" name="hairStyleImage" accept="image/*">
                        </div>
                    </div>

            </div>

            <!--Footer-->
            <div class="modal-footer flex-center">
                <button type="button" id="add" class="btn btn-primary">Save</button>
                <button type="button" class="btn border border-2 text-black" id="modalClose">Close</button>
            </div>
            </form>
        </div>
        <!--/.Content-->
    </div>
</div>`;

    $(".overlay").addClass("active");
    $("body").addClass("active");

    $("body").append(form);
  });


  $(document).on("click", "#addNewHairStyle #add", function () {
    let clickBtn = $(this);
    let data = [];
    data["hairName"] = $("#addNewHairStyle #hairName").val();
    data["gender"] = $("#addNewHairStyle #gender").val();
    data["image"] = ''
  
    let imageUploaded = $("#addNewHairStyle #hairStyleImage")[0].files[0];

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
    $(this).attr('disabled', true);


    if (imageUploaded) {
     

      let formData = new FormData();
      formData.append("image", imageUploaded);
      formData.append("location", "public/assets/uploads/hair-style/");
      uploadImage(formData)
        .then(function (imageData) {
          data["image"] = imageData["imageName"];
       

          addHairStyle(data)

            .then(function (data) {

            
        let form = `<tr role="row" class="even" id="ct${data.id}">
        <td>
            <input class="form-check-input" type="checkbox" name="checkbox" data-id="${data.id}">
        </td>
    
    
        <td><span class="hair-name">${data.name}</span>
    
            <div class=" edit-wrapper-all edit-wrapper-color d-flex g-2 pt-2">
                <button type="btn" class="btn text-black ">ID: ${data.id}</button>
                <button type="button" class="btn text-black quick-edit" data-id="${data.id}">Quick Edit</button>
                <button type="button" class="btn text-danger " id="deleteConfirm" data-id="${data.id}">Delete</button>
                
            </div>
    
        </td>
       <td class="attribute-category">${data.gender}</td>
       <td class="created-at">${data.createdAt}></td>
    
        </tr>`;
    
            $("#datable_1 tbody").prepend(form);
    
            $(".modal").remove();
            $(".overlay").removeClass("active");
            $("body").removeClass("active");
            
    
            alert("Successfuly Hair Style Added");
            })
            .catch(function (data) {

              $("body").removeClass("active");
              $(".spinner").remove();
              clickBtn.attr('disabled', false);
              $(".errorMessage").remove();
              if (typeof data.error === "object") {
                $.each(data.error, function (field, error) {
                  $("#addNewHairStyle #" + field).addClass("error");
                  $(`<span class=" errorMessage">${error}</span>`).insertAfter(
                    "#addNewHairStyle #" + field
                  );
                });
                
              } else {
              
                console.error("Error: " + data.error);
                console.log(data)
              }
            });
        })
        .catch(function (data) {
          $("body").removeClass("active");
          $(".overlay").removeClass("active");
          clickBtn.attr('disabled', false);
          $(".spinner").remove();
          $(this).attr('disabled', false);
          $(".errorMessage").remove();

          console.log(data);
        });
    }else{
     
      clickBtn.attr('disabled', false)
      $('.spinner').remove()
      alert('Image is required');
    }

  });

  $(document).on("click", ".edit-wrapper-hair-style .quick-edit", function () {
    let clickBtn = $(this);
    let id = $(this).data("id");

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );

    $(this).attr("disabled", true);
    getHairStyleDetail(id)
      .then(function (data) {
        clickBtn.attr("disabled", false);

        data = data[0];
   

        let form = `  <td class="quick-edit-wrapper" colspan="7">

        <div class="">
            <form action="http://localhost/richmane/admin/coupon/edit" id="editFormHairStyle"  autocompleete="off"
             class="row px-3 editFormAll" method="post" accept-charset="utf-8">
                <div id="errorWrapper"></div>
    
                <div class="mb-3">
                <label for="hairName" class="form-label">Hair Style Name*</label>
                <input type="text" class="form-control" id="hairName" value="${data.attribute_name}" aria-describedby="hairName" required>
            </div>
            <div class="mb-3 col-6">
                <label for="parentCategory" class="form-label">Gender*</label>

                <select class="form-select" id="gender" name="gender" aria-label="Default select example" required>
                    <option selected>Selecte Gender</option>
                    <option value="hairStyleMen" ${data.attribute_categorie == "hairStyleMen"? "selected": ""}>Male</option>
                    <option value="hairStyleWomen"  ${data.attribute_categorie == "hairStyleWomen"? "selected": ""}>Female</option>

                </select>
            </div>
       
            <div class="col-lg-12 text-start mb-2">
                        <div class="img-upload-wrap">
                            <img class="img-responsive mb-2 ${data.image != '' ? '': 'd-none'}" id="imagePreview" src="${baseUrl+'public/assets/uploads/hair-style/'}${data.image}" alt="upload_img" width="200" height="200">
                        </div>
                        <div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text">Upload Image</span>

                            <input type="file" id="hairStyleImage" class="upload" name="hairStyleImage" accept="image/*">
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


  $(document).on("click", "#editFormHairStyle #update", function () {
    let clickBtn = $(this);
    let data = [];
    data["id"] = $(this).data('id');
    data["hairName"] = $("#editFormHairStyle #hairName").val();
    data["gender"] = $("#editFormHairStyle #gender").val();
    let imageUploaded = $("#editFormHairStyle #hairStyleImage")[0].files[0];

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
    $(this).attr('disabled', true);


    if(imageUploaded){
      let formData = new FormData();
      formData.append("image", imageUploaded);
      formData.append("location", "public/assets/uploads/hair-style/");
      uploadImage(formData)
        .then(function (dataImage) {
          data["image"] = dataImage["imageName"];


          updateHairStyleDetail(data)
          .then(function (data) {
    
            clickBtn.attr('disabled', false);
            clickBtn.closest("tr").children("td").removeClass("d-none");
    
    
                 clickBtn.closest("tr").find('span.hair-name').html(data.name);
                  clickBtn.closest("tr").find('td.attribute-category').html(data.gender );
                 
                  $('td.quick-edit-wrapper').remove();
    
          })
          .catch(function (data) {
            $(".spinner").remove();
            clickBtn.attr('disabled', false)
            $(".errorMessage").remove();
            if (typeof data.error === "object") {
              $.each(data.error, function (field, error) {
                $("#editFormHairStyle #" + field).addClass("error");
                $(`<span class=" errorMessage">${error}</span>`).insertAfter(
                  "#editFormHairStyle #" + field
                );
              });
            } else {
              clickBtn.attr('disabled', false);
              console.error("Error: " + data.error);
            }
          });
          }) .catch(function (data) {
                $("body").removeClass("active");
                 $(".overlay").removeClass("active");
                 clickBtn.attr('disabled', false);
              $(".spinner").remove();
               $(this).attr('disabled', false);
               $(".errorMessage").remove();

               console.log(data);
     
                });
            
              }else{
                updateHairStyleDetail(data)
                .then(function (data) {
          
                  clickBtn.attr('disabled', false);
                  clickBtn.closest("tr").children("td").removeClass("d-none");
          
          
                       clickBtn.closest("tr").find('span.hair-name').html(data.name);
                        clickBtn.closest("tr").find('td.attribute-category').html(data.gender );
                      
                       
                        $('td.quick-edit-wrapper').remove();
          
                })
                .catch(function (data) {
                  $(".spinner").remove();
                  clickBtn.attr('disabled', false)
                  $(".errorMessage").remove();
                  if (typeof data.error === "object") {
                    $.each(data.error, function (field, error) {
                      $("#editFormHairStyle #" + field).addClass("error");
                      $(`<span class=" errorMessage">${error}</span>`).insertAfter(
                        "#editFormHairStyle #" + field
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
    ".edit-wrapper-hair-style #deleteConfirm",
    function () {
      let id = $(this).data("id");

      let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteHairStyle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
       <p>You Want to Delete This Hair Style Id : ${id}</p>

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


  $(document).on("click", "#modalConfirmDeleteHairStyle #confirm", function () {
    let id = $(this).data("id");

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
    $(this).attr("disabled", true);

    deleteHairStyle(id)
      .then(function (data) {
        $(".overlay").removeClass("active");
        $(".modal").remove();
        $("#ct" + data.id).remove();

        alert("Hair Style is Delete Successfully");
      })
      .catch(function (error) {
        $(".overlay").removeClass("active");
        $(".modal").remove();
        alert(error);
        console.error("Error: " + error);
      });
  });


  $(document).on("click", "#bulkApplyHairStyle", function () {
    let action = $("#bulkSelect").val();

    let checkedIds = []; // An array to store the "data-id" values of checked checkboxes

    $('#datable_1 input[type="checkbox"]:checked').each(function () {
      let checkboxId = $(this).data("id");
      checkedIds.push(checkboxId);
    });

    if (action == "delete") {
      let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteHairStyle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
       <p>You Want to Delete This Hair Style  Ids : ${checkedIds}</p>

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
    "#modalConfirmDeleteHairStyle #confirmBulk",
    function () {
      let ids = $(this).data("id");


      $(this).attr('disabled', true);
      
    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
      bulkDeleteHairStyle(ids)
        .then(function (data) {
          $(".overlay").removeClass("active");
          $(".modal").remove();

          for (let x of data.ids) {
            $("#ct" + x).remove();
          }

          alert("Hair Style is Delete Successfully");
        })
        .catch(function (error) {
          $(".overlay").removeClass("active");
          $(".modal").remove();
          alert(error);
          console.error("Error: " + error);
        });
    });


  // ============================  Faq ============================ //

  $(document).on("click", "button#addNewFaq", function () {

    let form = `
  
    <div class="modal fade in d-block " id="addNewFaq" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
    <div class="modal-dialog  modal-notify modal-danger" role="document">
        <!--Content-->
        <div class="modal-content text-center">
            <!--Header-->
            <div class="modal-header d-flex justify-content-center">
                <p class="heading">Add New Faq</p>
            </div>
            <div id="#errorWrapper"> </div>
            <!--Body-->
            <div class="modal-body">
                <form class="row">
                    <div class="mb-3">
                        <label for="heading" class="form-label">Heading*</label>
                        <input type="text" class="form-control" id="heading" aria-describedby="heading" required>
                    </div>
             
                    <div class=" col-12">
                        <label for="colorCategorie" class="form-label">Description*</label>
                        <textarea row="7" style="height: 200px" class="w-100" id="description"></textarea>

                    </div>
                    <div class="mb-3 col-12">
                    <label for="catergoryName" class="form-label">Category*</label>

                    <select class="form-select" id="categoryName" name="categoryName" aria-label="Default select example" required>
                        <option value="">Selecte Category</option>
                        

                    </select>
                </div>
            <!--Footer-->
            <div class="modal-footer flex-center">
                <button type="button" id="add" class="btn btn-primary">Save</button>
                <button type="button" class="btn border border-2 text-black" id="modalClose">Close</button>
            </div>
            </form>
        </div>
        <!--/.Content-->
    </div>
</div>`;



    $(".overlay").addClass("active");
    $("body").addClass("active");

    $("body").append(form);


    getProductCategoryFaq()
    .then(function (data) {
      $("#categoryName").append(data);
    })
    .catch(function (error) {
      console.log(error);
    });

  });
  $(document).on("click", "#addNewFaq #add", function () {
    let clickBtn = $(this);
    let faqData = [];
    faqData["heading"] = $("#addNewFaq #heading").val();
    faqData["description"] = $("#addNewFaq #description").val();
    faqData["categoryName"] = $("#addNewFaq #categoryName").val();

 
 
    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
    $(this).attr('disabled', true);
          addFaq(faqData)
            .then(function (data) {
                  
        let form = `<tr role="row" class="even" id="ct${data.id}">
        <td>
            <input class="form-check-input" type="checkbox" name="checkbox" data-id="${data.id}">
        </td>
    
    
        <td><span class="heading">${data.heading}</span>
    
            <div class=" edit-wrapper-all edit-wrapper-color d-flex g-2 pt-2">
                <button type="btn" class="btn text-black ">ID: ${data.id}</button>
                <button type="button" class="btn text-black quick-edit" data-id="${data.id}">Quick Edit</button>
                <button type="button" class="btn text-danger " id="deleteConfirm" data-id="${data.id}">Delete</button>
                
            </div>
    
        </td>
        <td class="sorting_1 category"> ${data.categoryName}</td>
       <td class="is_active">Yes</td>
      
    
        </tr>`;
    
            $("#datable_1 tbody").prepend(form);
    
            $(".modal").remove();
            $(".overlay").removeClass("active");
            $("body").removeClass("active");
            
    
            alert("Successfuly Faq Added");
            })
            .catch(function (data) {

              $("body").removeClass("active");
              $(".spinner").remove();
              clickBtn.attr('disabled', false);
              $(".errorMessage").remove();
              if (typeof data.error === "object") {
                $.each(data.error, function (field, error) {
                  $("#addNewFaq #" + field).addClass("error");
                  $(`<span class=" errorMessage">${error}</span>`).insertAfter(
                    "#addNewFaq #" + field
                  );
                });
                
              } else {
              
                console.error("Error: " + data.error);
                console.log(data)
              }
                });
                
              
      

  });

$(document).on("click", ".edit-wrapper-faq .quick-edit", function () {
  let clickBtn = $(this);
  let faqId = $(this).data("id");

  $(this).append(
    "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
  );

  $(this).attr("disabled", true);
  getFaqDetail(faqId)
    .then(function (data) {
      clickBtn.attr("disabled", false);

      data = data[0];
 

      let form = `  <td class="quick-edit-wrapper" colspan="7">

      <div class="">
          <form action="http://localhost/richmane/admin/coupon/edit" id="editFormFaq"  autocompleete="off"
           class="row px-3 editFormAll" method="post" accept-charset="utf-8">
              <div id="errorWrapper"></div>
  
              <div class="mb-3">
              <label for="heading" class="form-label">Heading*</label>
              <input type="text" class="form-control" id="heading" value="${data.heading}" aria-describedby="heading" required>
          </div>
          <div class=" col-12">
          <label for="colorCategorie" class="form-label">Description*</label>
          <textarea row="7" style="height: 200px" class="w-100" id="description">${data.description}</textarea>

      </div>
      <div class="mb-3 col-12">
      <label for="catergoryName" class="form-label">Category*</label>

      <select class="form-select" id="categoryName" name="categoryName" aria-label="Default select example" required>
          <option value=" ${data.category_name}">${data.category_name}</option>
         
      </select>
  </div>

  
              <div class="button-wrappper">
              <button type="button" id="update" class="btn btn-primary mb-3 me-3" data-id="${data.faq_id}" >Update</button>
              <button type="button" id="cancel" class="btn text-black border border-black border-2 mb-3">Cancel</button>
  
  
              </div>
  
  
  
          </form>
      </div>
  </td>`;

  getProductCategoryFaq()
  .then(function (data) {
    $("#categoryName").append(data);
  })
  .catch(function (error) {
    console.log(error);
  });
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
$(document).on("click", "#editFormFaq #update", function () {
  let clickBtn = $(this);
  let faqData = [];
  faqData['faqId']=  $(this).data('id')
  faqData["heading"] = $("#editFormFaq #heading").val();
  faqData["description"] = $("#editFormFaq #description").val();
  faqData["categoryName"] = $("#editFormFaq #categoryName").val();


  $(this).append(
    "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
  );
  $(this).attr('disabled', true);
  updateFaq(faqData)
  .then(function (data) {
    clickBtn.attr('disabled', false);
    clickBtn.closest("tr").children("td").removeClass("d-none");

         clickBtn.closest("tr").find('span.heading').html(data.heading);
          clickBtn.closest("tr").find('td.category').html(data.categoryName );
         
          $('td.quick-edit-wrapper').remove();

  })
     .catch(function (data) {

           $(".spinner").remove();
                  clickBtn.attr('disabled', false)
                  $(".errorMessage").remove();
                  if (typeof data.error === "object") {
                    $.each(data.error, function (field, error) {
                      $("#editFormFaq #" + field).addClass("error");
                      $(`<span class=" errorMessage">${error}</span>`).insertAfter(
                        "#editFormFaq #" + field
                      );
                    });
                  } else {
                    clickBtn.attr('disabled', false);
                    console.error("Error: " + data.error);
                  }

                             });


                            })

                            $(document).on(
                              "click",
                              ".edit-wrapper-faq #deleteConfirm",
                              function () {
                                let faqId = $(this).data("id");
                          
                                let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteFaq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                                 <p>You Want to Delete This faq Id : ${faqId}</p>
                              </div>
                              <!--Footer-->
                              <div class="modal-footer flex-center">
                                <button type="button" id="confirm"  class="btn btn-danger" data-id="${faqId}">Yes</button>
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
                          

                            $(document).on("click", "#modalConfirmDeleteFaq #confirm", function () {
                              let faqId = $(this).data("id");
                          
                              $(this).append(
                                "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
                              );
                              $(this).attr("disabled", true);
                          
                              deleteFaq(faqId)
                                .then(function (data) {
                                  $(".overlay").removeClass("active");
                                  $(".modal").remove();
                                  $("#ct" + data.faqId).remove();
                                  alert("Faq is Delete Successfully");
                                })
                                .catch(function (error) {
                                  $(".overlay").removeClass("active");
                                  $(".modal").remove();
                                  alert(error);
                                  console.error("Error: " + error);
                                });
                            });

                            
                            $(document).on("click", "#bulkApplyFaq", function () {
                              let action = $("#bulkSelect").val();
                          
                              let checkedIds = []; // An array to store the "data-id" values of checked checkboxes
                          
                              $('#datable_1 input[type="checkbox"]:checked').each(function () {
                                let checkboxId = $(this).data("id");
                                checkedIds.push(checkboxId);
                              });
                          
                              if (action == "delete") {
                                let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteFaq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                                 <p>You Want to Delete This Faq  Ids : ${checkedIds}</p>
                          
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
                              "#modalConfirmDeleteFaq #confirmBulk",
                              function () {
                                let faqIds = $(this).data("id");
                          
                          
                                $(this).attr('disabled', true);
                                
                              $(this).append(
                                "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
                              );
                                bulkDeleteFaq(faqIds)
                                  .then(function (data) {
                                    $(".overlay").removeClass("active");
                                    $(".modal").remove();
                          
                                    for (let x of data.faqIds) {
                                      $("#ct" + x).remove();
                                    }
                          
                                    alert("Faq is Delete Successfully");
                                  })
                                  .catch(function (error) {
                                    $(".overlay").removeClass("active");
                                    $(".modal").remove();
                                    alert(error);
                                    console.error("Error: " + error);
                                  });
                              });
                          

  // ============== Get Product Detail ===================== //
  function getProductDetail(productId) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "admin/products/" + productId,
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


    // ============== Get Product Detail ===================== //
    function getAttribute(categoryId) {
      return new Promise(function (resolve, reject) {
        $.ajax({
          url: baseUrl + "admin/get-attribute/" + categoryId,
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
  // ============== Get Product Detail ===================== //
  function getHelpMeChoose(productId, gender) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "admin/helpMeChoose/" + productId,
        type: "GET",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        data: {
          'gender': gender
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
  function getProductCategoryFaq() {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "admin/product-category-faq/",
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

  function updateProductDetail(data) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/products",
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
// =========================  Upload Image ====================== //
  function uploadImage(formData) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/upload-image",
        type: "POST",
        contentType: false,
        processData: false,
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        data: formData,
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

    function deleteProduct(productId) {
      return new Promise(function (resolve, reject) {
        $.ajax({
          url: baseUrl + "session/admin/products/" + productId,
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

    function bulkDeleteProduct(productIds){
      return new Promise(function (resolve, reject) {
        $.ajax({
          url: baseUrl + "session/admin/product/delete",
          type: "POST",
          headers: {
            "X-Requested-With": "XMLHttpRequest",
          },
          data: {
            productIds: productIds
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
  

       // ============== Delete Product Image  ===================== //
       function deleteProductImage(imageId, imageName) {
        return new Promise(function (resolve, reject) {
          $.ajax({
            url: baseUrl + "session/admin/gallery-image",
            type: "POST",
            headers: {
              "X-Requested-With": "XMLHttpRequest",
            },
            data: {
              imageId : imageId,
              imageName : imageName
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

//  ============= add Coupon ================= //
      function addCoupon(data) {
        return new Promise(function (resolve, reject) {
          $.ajax({
            url: baseUrl + "session/admin/add-coupon",
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
//  get coupon details
      function getCouponDetail(couponId) {
        return new Promise(function (resolve, reject) {
          $.ajax({
            url: baseUrl + "admin/coupon/" + couponId,
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
    
    
      function updateCouponDetail(data) {
        return new Promise(function (resolve, reject) {
          $.ajax({
            url: baseUrl + "session/admin/update-coupon",
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

      
  function deleteCoupon(couponId) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/coupon/" + couponId,
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

  function bulkDeleteCoupon(couponIds) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/coupon/delete",
        type: "POST",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        data: {
          couponIds: couponIds,
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


//  =========== add color ============================= //
function addColor(data) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: baseUrl + "session/admin/add-color",
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

function getColorDetail(colorId) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: baseUrl + "admin/color/" + colorId,
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

    
function updateColorDetail(data) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: baseUrl + "session/admin/update-color",
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

function deleteColor(colorId) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: baseUrl + "session/admin/color/" + colorId,
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

function bulkDeleteColor(colorIds) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: baseUrl + "session/admin/color/delete",
      type: "POST",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
      data: {
        colorIds: colorIds,
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



//  =========== add Hair Style ============================= //
function addHairStyle(data) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: baseUrl + "session/admin/add-hair-style",
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

function getHairStyleDetail(id) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: baseUrl + "admin/hair-style/" + id,
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

    
function updateHairStyleDetail(data) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: baseUrl + "session/admin/update-hair-style",
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

function deleteHairStyle(id) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: baseUrl + "session/admin/hair-style/" + id,
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

function bulkDeleteHairStyle(ids) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: baseUrl + "session/admin/hair-style/delete",
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

// ================================ FAQ =======================================//\

function addFaq(data) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: baseUrl + "session/admin/add-faq",
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

function getFaqDetail(faqId) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: baseUrl + "admin/faq/" + faqId,
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

    
function updateFaq(data) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: baseUrl + "session/admin/update-faq",
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

function deleteFaq(faqId) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: baseUrl + "session/admin/faq/" + faqId,
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

function bulkDeleteFaq(faqIds) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: baseUrl + "session/admin/faq/delete",
      type: "POST",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
      data: {
        faqIds: faqIds,
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
