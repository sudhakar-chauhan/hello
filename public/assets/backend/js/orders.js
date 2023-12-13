import { baseUrl } from "./custom.js";


$(document).ready(function(){



    $(document).on("click", ".edit-wrapper-orders .quick-edit", function () {
        let clickBtn = $(this);
        let orderId = $(this).data("id");
    
        $(this).append(
          "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
        );
    
        $(this).attr("disabled", true);
        getOrderStatus(orderId)
          .then(function (data) {
            clickBtn.attr("disabled", false);
    
            data = data[0];
        
            let form = `  <td class="quick-edit-wrapper" colspan="5">
    
            <div class="">
                <form action="http://localhost/richmane/admin/order/edit" id="editFormOrders" autocompleete="off"
                 class="row px-3 editFormAll" method="post" accept-charset="utf-8">
                    <div id="errorWrapper"></div>
                    <div class="form-outline mb-4 col-4">
                        <label for="orderStatus" class="from-label">Order Status</label>
                        <select name="orderStatus" class="form-select" id="orderStatus">
                         <option value="">Select a Order Status</option>                                      
                         <option value="1" ${data["order_status"] == 1 ? "selected": ""}>Processing</option>
                         <option value="2" ${data["order_status"] == 2 ? "selected": ""}>Shipped</option>
                         <option value="3" ${data["order_status"] == 3 ? "selected": ""}>Delivered</option>
                         <option value="4" ${data["order_status"] == 4 ? "selected": ""}>Canceled</option>
                         <option value="5" ${data["order_status"] == 5 ? "selected": ""}>On Hold</option>
                         <option value="6" ${data["order_status"] == 6 ? "selected": ""}>Refunded</option>
                         <option value="8" ${data["order_status"] == 7 ? "selected": ""}>Payment Failed</option>
                        </select>        
                    </div>
        
        
                    <div class="button-wrappper">
                    <button type="button" id="update" class="btn btn-primary mb-3 me-3" data-id="${data["order_id"]}" >Update</button>
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


      $(document).on("click", "#editFormOrders #update", function () {
        let clickBtn = $(this);
        let orderIds = [$(this).data('id')];
        let orderStatus = $('#editFormOrders #orderStatus').val()
      
        $(this).attr("disabled", true);
      
        $(this).append(
          "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
        );
        orderChageStatus(orderStatus,orderIds)
        .then(function (data) {
          clickBtn.attr("disabled", false);
          clickBtn.closest("tr").children("td").removeClass("d-none");
 
          clickBtn
            .closest("tr")
            .find("td.order-status")
            .html(data.order_status);

            
        $("td.quick-edit-wrapper").remove();
        })
        .catch(function (data) {
          $(".spinner").remove();
          clickBtn.attr("disabled", false);
          $(".errorMessage").remove();
          if (typeof data.error === "object") {
            $.each(data.error, function (field, error) {
              $("#editFormOrders #" + field).addClass("error");
              $(`<span class=" errorMessage">${error}</span>`).insertAfter(
                "#editFormOrders #" + field
              );
            });
          } else {
            clickBtn.attr("disabled", false);
            console.error("Error: " + data.error);
            console.log(data);
          }
        });
       
      });
      



    $(document).on("click", "#bulkApplyOrder", function(){

        let clickBtn = $(this);
        let orderStatus = $('#bulkSelect').val();
        
       
        let orderIds = []; // An array to store the "data-id" values of checked checkboxes
        $(this).append(
            ` <div class='spinner spinner-border spinner-border-sm ms-2' role='status'><span class='visually-hidden'>Loading...</span></div>
     
      `);
       $(this).attr('disabled', true);
        $('#datable_1 input[type="checkbox"]:checked').each(function() {
            let checkboxId = $(this).data('id');
            orderIds.push(checkboxId);
        });
       
        orderChageStatus(orderStatus,orderIds)
        .then(function (data) {
            location.reload(true);
        })
        .catch(function (error) {
            console.log(error);
      

            $('.spinner').remove();
             clickBtn.attr('disabled', false)
            alert(error);
       
          console.error("Error: " + error);
        });
       });
       


     $(document).on("click", ".edit-wrapper-orders .view-order", function(){

      let clickBtn = $(this);
      let orderId = $(this).data("id");
  
      $(this).append(
        "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
      );
      getOrderDetail(orderId)
      .then(function (data) {
        clickBtn.attr("disabled", false);
        $(".spinner").remove();

          let orderStatus = '';
        let order_data = data.order_data[0];
        let order_meta = data.order_meta;
     

        if(order_data.order_status == 0){
          orderStatus = "<span class='status_pending'> Pending </span>";
          
         }else if(order_data.order_status == 1){
          orderStatus = "<span class='status_processing'>  Processing </span>";
         }
         else if(order_data.order_status == 2){
          orderStatus = "<span class='status_shipped'> Shipped </span>";
        }
        else if(order_data.order_status == 3){
          orderStatus = "<span class='status_delivered'> Delivered </span>";
        }
        else if(order_data.order_status == 4){
          orderStatus ="<span class='status_canceled'> Canceled </span>";
        }
        else if(order_data.order_status == 5){
          orderStatus = "<span class='status_hold'> On Hold </span>";
        }
        else if(order_data.order_status == 6){
          orderStatus = "<span class='status_refunded'> Refunded </span>";
        }
        else if(order_data.order_status == 7){
          orderStatus = "<span class='status_failed'> Failed </span>";
        }
        else if(order_data.order_status == 8){
          orderStatus ="<span class='status_payment_failed'> payment Failed </spa>";
        }
        let form = `   
        <div class="modal fade in show" id="viewOrder" tabindex="-1" aria-labelledby="viewOrder" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
              <div class="modal-header">
    
                <h1 class="modal-title fs-4" id="OrderNumber">Order #${order_data.order_number}</h1>
    
                <div class="d-flex justify-space-between">
                  <p class="me-3">${orderStatus}</p>
                  <button type="button" id="modalClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
              </div>
              <div class="modal-body">
                <div class="row">

                <div class="shipping-wrapper col-6">
                <h5 class="pb-1">Shipping Address</h5>
                <p>${order_data.address} </p>
                <p>${order_data.state} <span>${order_data.city}</span> <span>-${order_data.zipcode}</span></p>
                <p>${order_data.country}</p>

                <h6 class="mt-3 pb-1"> Phone</h6>
                <p><a href="tel:${order_data.phone}">${order_data.phone_number}</a></p>
                <h6 class="mt-3 pb-2">Email</h6>
                <p><a href="mailto:${order_data.email}">${order_data.email}</a></p>




              </div>
                  <div class="billing-wrapper col-6">
                    <h5 class="pb-1">Billing Address</h5>
                    <p>${order_data.billing_address} </p>
                    <p>${order_data.billing_state} <span>${order_data.billing_city}</span> <span>-${order_data.billing_zipcode}</span></p>
                    <p>${order_data.billing_country}</p>
    
                    <h6 class="mt-3 pb-1"> Phone</h6>
                    <p><a href="tel:${order_data.billing_phone}">${order_data.billing_phone_number}</a></p>
                    <h6 class="mt-3 pb-2">Email</h6>
                    <p><a href="mailto:${order_data.billing_email}">${order_data.email}</a></p>
    
    
    
    
                  </div>
             
    
                  <div class="col-12 mt-3">
                    <h5 class="pb-1">Payment Via</h5>
                    <p> ${order_data.payment_method} </p>
                  </div>
                  <div class="col-12 order-details mt-3">
                  <h5 class="pb-3">Product Details</h5>
                    <div class="cart-items mb-2">
                      <div class="cart-item card" data-id="51">
                        <div class="row g-0">
                          <div class="col-3 text-center">
    
                            <img src="http://localhost/richmane/public/assets/uploads/products/${order_data.feature_image}" width="60" height="80" alt="product-image">
    
                          </div>
                          <div class="col-9">
                            <div class="card-body">
    
                              <h6 class="cart-title">${order_data.product_name} <span class="cart-quantity">QTY: ${order_data.quantity}</span>
                              </h6>
    
                              <div class="row g-0 align-items-center">
    
                                <div class="accordian-wrapper col-6">
                                  <div class="accordion accordion-flush" id="accordionViewDetils">
                                    <div class="accordion-item">
                                      <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#viewDetails51" aria-expanded="true" aria-controls="flush-collapseOne">
                                          view details
                                        </button>
                                      </h2>
                                    </div>
                                  </div>
    
                                </div>
                                <div class="cart-price-wrapper col-4 text-center">
                                  <p class="cart-price" data-price="${order_data.final_price}">$${order_data.final_price}</p>
                                </div>
    
                              </div>
    
                            </div>
                          </div>
    
    
                          <div class="col-12">
                            <div id="viewDetails51" class="accordion-collapse collapse" data-bs-parent="#accordionViewDetils" style="">
                              <div class="accordion-body">
                                <table class="table">
                                  <tbody>
                                  ${order_meta}
                                  </tbody>
                                </table>
    
    
                              </div>
                            </div>
                          </div>
                        </div>
    
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modalClose" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Edit</button>
              </div>
            </div>
          </div>
        </div>
    `;

    $('body').addClass('active')

    $('.overlay').addClass('active')
       
     $('body').append(form);


      
      })
      .catch(function (error) {
        clickBtn.attr("disabled", false);
        $(".spinner").remove();
        console.error("Error: " + error);
        alert(error);
      });


     });  



     $('.printInvoice').click(function () {
      // 1. Open the target HTML page in a new window or tab.

      let orderId = $(this).data('id');
      let newWindow = window.open(`${baseUrl}/admin/invoice/${orderId}`, '_blank');

      // 2. Check if the new window is successfully opened.
      if (newWindow) {
        // 3. Once the new window is loaded, trigger the print dialog.
        newWindow.onload = function () {
          newWindow.print();
        };
      } else {
        // Handle cases where pop-up blockers prevent opening a new window.
        alert('Please allow pop-ups to print the page.');
      }
    });

    $('.downloadButton').click(function () {
   
      $(this).append(
        "<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>"
      );
      let orderId = $(this).data('id');
      console.log(orderId);
      
     let  urlToDownload = `${baseUrl}admin/invoice/${orderId}`;

     $.ajax({
      url: urlToDownload,
      type: 'GET',
      dataType: 'html',
      success: function (data) {

        $('.spinner').remove()
          // Parse the HTML content from the response
          var parsedData = $(data);
  
          // Select the element with the "print-section" class
          var sectionToConvert = parsedData.find('.print-section');

          sectionToConvert = sectionToConvert[0].outerHTML
        
  
          // Define the PDF conversion options
          var pdfOptions = {
              margin: 10,
              filename: `invoice-${orderId}.pdf`,
              image: { type: 'jpeg', quality: 1 },
              html2canvas: {  dpi: 192,
                scale:4,
                letterRendering: true,
                useCORS: true , scrollY: 0  },
              jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
              header:
		'<div style="text-align:center;">Page <span class="page"></span> of <span class="total"></span></div>',
	footer:
		'<div style="text-align:center;">Generated by my app on ' +
		new Date().toLocaleDateString() +
		'</div>'
          };
  
          // Perform the PDF conversion
          html2pdf()
              .from(sectionToConvert) // Use [0] to select the first element with the class
              .set(pdfOptions)
              .outputPdf()
              .then(function (pdf) {
                
              }).save()
              .catch(function (error) {
                  console.error('Error:', error);
              });
      },
      error: function (error) {
        $('.spinner').remove()
          console.error('Error fetching the webpage:', error);
      }
  });
    });
       function orderChageStatus(orderStatus,orderIds){
        return new Promise(function (resolve, reject) {
          $.ajax({
            url: baseUrl + "session/admin/order-status",
            type: "POST",
            headers: {
              "X-Requested-With": "XMLHttpRequest",
            },
            data: {
                orderStatus: orderStatus,
              orderIds: orderIds
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
      function getOrderStatus(orderId) {
        return new Promise(function (resolve, reject) {
          $.ajax({
            url: baseUrl + "admin/order/" + orderId,
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

      function getOrderDetail(orderId) {
        return new Promise(function (resolve, reject) {
          $.ajax({
            url: baseUrl + "admin/order-detail/" + orderId,
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







  

});