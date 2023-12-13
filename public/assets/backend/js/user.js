import { baseUrl } from "./custom.js";
$(document).ready(function () {
 
  $(document).on("click", ".edit-wrapper-user .quick-edit", function () {
    let clickBtn = $(this);
    let UserId = $(this).data("id");

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );

    $(this).attr('disabled', true);
    getQuickUserDetail(UserId)
      .then(function (data) {
        data = data[0];
        clickBtn.attr('disabled', false);




        let form = `  <td class="quick-edit-wrapper" colspan="5">

        <div class="">
            <form action="http://localhost/richmane/admin/user/edit" id="editFormUser" autocompleete="off"
             class="row px-3 editFormAll" method="post" accept-charset="utf-8">
                <div id="errorWrapper"></div>
    

                <div class="d-none">
                <input type="hidden" id="id" value="${data.user_id}">
                </div>
                <div class="form-outline mb-4 col-4">
                    <label for="firstName" class="from-label">First Name</label>
                    <p> ${data["first_name"]} <p>
    
                </div>
                <div class="form-outline mb-4 col-4">
                    <label for="lastName" class="from-label">Last Name</label>
                    <p> ${data["last_name"]} <p>
    
    
                </div>
                
  
                <div class="form-outline mb-4 col-4">
                    <label for="dob" class="from-label">Date of Birth</label>
                    <p> ${data["dob"]} <p>
    
    
                </div>
    
                <div class="form-outline mb-4 col-4">
                <label for="productCategory" class="from-label">User Acite </label>
                <select name="userStatus" class="form-select" id="userStatus">
                    <option value="0" ${data['is_active'] == 0 ? 'selected' : ''}>Unverfied</option>
                    <option value="1" ${data['is_active'] == 1 ? 'selected' : ''}>Active</option>
                    <option value="2" ${data['is_active'] == 2 ? 'selected' : ''}>Blocked</option>
                </select>

            </div>
                <div class="button-wrappper">
                <button type="button" id="update" class="btn btn-primary mb-3 me-3" data-id="${
                  data["user_id"]
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
  $(document).on("click", "#editFormUser #update", function () {
    let clickBtn = $(this);
    let data = [];
    data["user_id"] = $(this).data("id");
    data["userStatus"] = $("#editFormUser #userStatus").val();
  

    $(this).append(
      "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
    );
    $(this).attr('disabled', true);


 
      updateUserDetails(data)
      .then(function (data) {

        clickBtn.attr('disabled', false);
        clickBtn.closest("tr").children("td").removeClass("d-none");

              clickBtn.closest("tr").find('td.user-status').html(data.userStatus);
            
              $('td.quick-edit-wrapper').remove();

      })
      .catch(function (data) {

      
        $(".spinner").remove();
        clickBtn.attr('disabled', false)
        $(".errorMessage").remove();
        if (typeof data.error === "object") {
          $.each(data.error, function (field, error) {
            $("#editFormUser #" + field).addClass("error");
            $(`<span class=" errorMessage">${error}</span>`).insertAfter(
              "#editFormUser #" + field
            );
          });
        } else {
          clickBtn.attr('disabled', false);
          console.error("Error: " + data.error);
        }
      });
  
    


  });
  // ============== Delete User Modal ========================= //
  $(document).on("click", ".edit-wrapper-user #deleteConfirmUser", function () {
    let userId = $(this).data("id");


  let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
       <p>You Want to Delete This User Id : ${userId}</p>

    </div>

    <!--Footer-->
    <div class="modal-footer flex-center">
      <button type="button" id="confirm"  class="btn btn-danger" data-id="${userId}">Yes</button>
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
$(document).on("click", "#modalConfirmDeleteUser #confirm", function(){


  let id = $(this).data('id');
  $(this).append(
    "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
  );
  $(this).attr('disabled', true);

  deleteUser(id)
  .then(function (data) {
    
    $(".overlay").removeClass("active");
    $(".modal").remove();
    $('#pr'+data.id).remove();

    alert('User is Delete Successfully');

  })
  .catch(function (error) {
    $('remove')
    $(".overlay").removeClass("active");
    $(".modal").remove();
    alert(error);
    console.error("Error: " + error);
  });




});
//  =========================== Delete Product Bulk ====================== //

$(document).on("click", "#bulkApplyUser", function(){

 let action = $('#bulkSelect').val();

 let checkedIds = []; // An array to store the "data-id" values of checked checkboxes

 $('#datable_1 input[type="checkbox"]:checked').each(function() {
     let checkboxId = $(this).data('id');
     checkedIds.push(checkboxId);
 });


 if(action == 'delete'){
  let form = `<div class="modal fade in d-block deleteModal" id="modalConfirmDeleteUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
       <p>You Want to Delete This User Ids : ${checkedIds}</p>

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
$(document).on("click", "#modalConfirmDeleteUser #confirmBulk", function(){
  $(this).append(
    "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
  );
   $(this).attr('disabled', true);

  let userIds = $(this).data('id');
  bulkDeleteUser(userIds)
  .then(function (data) {
    
    $(".overlay").removeClass("active");
    $(".modal").remove();

  for (let x of data.userIds) {

    $('#pr' + x).remove();
   
  }
    alert('User is Delete Successfully');
  })
  .catch(function (error) {

    $(".overlay").removeClass("active");
    $(".modal").remove();
    alert(error);
    console.error("Error: " + error);
  });
});
  // ============== Get User Detail ===================== //
  function getQuickUserDetail(userId) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "admin/quick-user/" + userId,
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

  function updateUserDetails(data) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl + "session/admin/user",
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
   
  // ================= Delete User ======================//

    function deleteUser(userId) {
      return new Promise(function (resolve, reject) {
        $.ajax({
          url: baseUrl + "session/admin/user/" + userId,
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

    function bulkDeleteUser(userIds){
      return new Promise(function (resolve, reject) {
        $.ajax({
          url: baseUrl + "session/admin/user/delete",
          type: "POST",
          headers: {
            "X-Requested-With": "XMLHttpRequest",
          },
          data: {
            userIds: userIds
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
})
