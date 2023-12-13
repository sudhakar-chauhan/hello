
const baseUrl = "http://localhost/richmane/";
// const baseUrl = "https://devclientserver.com/richmane/";

$(document).on('ready', function(){


  $('#multiple-checkboxes').multiselect({
    includeSelectAllOption: true,
  });


  var urlParams = new URLSearchParams(window.location.search);
  var section = urlParams.get("section");

  
  if (section) {
    var targetElement = $("#"+section);

 

    if (targetElement.length) {
        $('html, body').animate({
            scrollTop: targetElement.offset().top
        }, 1000); // Adjust the animation duration as needed
    }
}

$(document).on('change', '#totalSaleMonth', function(){

   let data = $(this).val();

   $('.total-sale-data').html(data);
   const d = new Date();
   var day = d.getDate();

   var selectedOption = $("#totalSaleMonth option:selected");
   var selectedMonth = selectedOption.data("month");
   const month = ["January","February","March","April","May","June","July","August","September","October","November","December"];

   if(selectedMonth == 3 || selectedMonth == 6 || selectedMonth == 12){
  
    const lastMonths = [];
     if(selectedMonth == 3){
      var dataLast = $("#total_sale_chart").data('salethree');
     }else if(selectedMonth == 6){
      var dataLast = $("#total_sale_chart").data('salesix');
     }
     else if(selectedMonth == 12){
      var dataLast = $("#total_sale_chart").data('saletew');
     }
	
    for (let i = 0; i < selectedMonth; i++) {
   const lastMonthIndex = (d.getMonth() - i + 12) % 12;
   lastMonths.push(month[lastMonthIndex]);
    }
   chartChange(lastMonths.reverse(), dataLast);
}else if(selectedMonth == 1){

	 let currentDays = [];
		for (let i = 1; i <= day; i++) {
			currentDays.push(i);
		}
  
    var dataLast = $("#total_sale_chart").data('sale');


    chartChange(currentDays, dataLast)

   }else{
    let years = $('#years').data('years');
    let amount = $('#amounts').data('amounts');

    chartChange(years, amount);
   }
  
})

  $(document).on(
    "click",
    ".deleteModal #deleteCancel",
    function () {
      $(".overlay").removeClass("active");
      $(this).closest(".modal").remove();
    }
  );
  $(document).on("click", ".editFormAll #cancel", function () {
    $(this).closest("tr").children("td").removeClass("d-none");
    $(this).closest("td").remove("td");
  });


  $(document).on('change','.upload', function(e) {
    var fileInput = e.target;
    var imagePreview = $(this).closest('.col-lg-12').find('img');

    // Check if a file is selected
    if (fileInput.files.length > 0) {
        var file = fileInput.files[0];
        var reader = new FileReader();
        imagePreview.removeClass('d-none')

        // Set up the FileReader to display the image
        reader.onload = function(e) {
            imagePreview.attr('src', e.target.result);
          
        };

        // Read the selected file as a data URL
        reader.readAsDataURL(file);
    }else{
      imagePreview.addClass('d-none')
    }

  });

  $(document).on("click", "button#modalClose", function () {

    $(".modal").remove();
    $(".overlay").removeClass("active");
    $("body").removeClass("active");

   
  });



  tinymce.init({
    selector: '.blogDescription',
    plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
  });





});


function chartChange(months,data){
  var total_sale_chart = echarts.init(document.getElementById('total_sale_chart'));

		let currentMonth = months;
		var markLineData = [];
		for (var i = 1; i < data.length; i++) {
			markLineData.push([{
				xAxis: i - 1,
				value: (data[i] + data[i-1]).toFixed(2)
			}, {
				xAxis: i,
				yAxis: data[i]
			}]);
		}

		//option
		var option = {
			tooltip: {
				trigger: 'axis',
				backgroundColor: 'rgba(33,33,33,1)',
				borderRadius:0,
				padding:10,
				axisPointer: {
					type: 'cross',
					label: {
						backgroundColor: 'rgba(33,33,33,1)'
					}
				},
				textStyle: {
					color: '#fff',
					fontStyle: 'normal',
					fontWeight: 'normal',
					fontFamily: "'Roboto', sans-serif",
					fontSize: 12
				}	
			},
			color: ['#2196F3'],	
			grid:{
				show:false,
				top: 100,
				bottom: 10,
				containLabel: true,
			},
			xAxis: {
				data: currentMonth,
				axisLine: {
					show:true
				},
				axisLabel: {
					textStyle: {
						color: '#878787'
					}
				},
			},
			yAxis: {
				axisLine: {
					show:false
				},
				axisLabel: {
					textStyle: {
						color: '#878787'
					}
				},
				splitLine: {
					show: false,
				},
			},
			series: [{
				type: 'line',
				data: data,
        label: {
          show: true
        },
				markLine: {
					smooth: true,
							effect: {
								show: true
							},
							distance: 10,
					label: {
						normal: {
							position: 'middle'
						}
					},
					symbol: ['none', 'none'],
          data: markLineData
				
				}
			}]
		};
		total_sale_chart.setOption(option);
		total_sale_chart.resize();
}

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

  
export {baseUrl, uploadImage};