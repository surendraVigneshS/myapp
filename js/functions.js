
function inWords (num) {
    var a = ['','One ','Two ','Three ','Four ', 'Five ','Six ','Seven ','Eight ','Nine ','Ten ','Eleven ','Twelve ','Thirteen ','Fourteen ','Fifteen ','Sixteen ','Seventeen ','Eighteen ','Nineteen '];
    var b = ['', '', 'Twenty','Thirty','Forty','Fifty', 'Sixty','Seventy','Eighty','Ninety'];

    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'Lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'Thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]])  : ' ';
    return str+'Rupees Only';
} 

function previewImages() 
{  
  var preview = document.querySelector('#preview'); 
  if (this.files) {
    [].forEach.call(this.files, readAndPreview);
  }
}

function readAndPreview(file) { 
  if (!/\.(jpe?g|png|pdf)$/i.test(file.name)) 
  {
    return alert(file.name + " is not an image");
  }  
  var reader = new FileReader(); 
  reader.addEventListener("load", function() {
    var image = new Image();
    image.width = 200;
    image.height = 200;
    image.title  = file.name;
    image.src    = this.result;
    image.className  = "answerImageClass";
    preview.appendChild(image);
  }); 
  $('#filename').text(file.name);
  reader.readAsDataURL(file);
  
}



function aprrovePurchase(purchaseId,adminId,adminRole){
  swal({
    title: 'Are you sure?',
    text: "You want dispatch is order!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger m-l-10',
    confirmButtonText: 'Yes'
})
.then((willDelete) => {
   if (willDelete) {
        $.ajax({
            url: "./include/ajax-call.php",
            cache: false,
            type: 'POST',
            data:{orderdispatch:1,orderid:orderid,adminid:adminid},
            success : function(data){
                if(data == '1'){
                    swal("Done!","Order Updated succesfully!","success");
                    $("#dispatch-card").load(location.href+" #dispatch-card>*","");
                }else{
                    toastr["danger"]("Error in Dispatch Order");
                }
            }
        });
    }else{
        swal("Cancelled","","error");
    } 
});
}

function aprrovePurchase(purchaseId,adminId,adminRole){
  swal({
    title: 'Are you sure?',
    text: "You want dispatch is order!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger m-l-10',
    confirmButtonText: 'Yes'
})
.then((willDelete) => {
   if (willDelete) {
        $.ajax({
            url: "./include/ajax-call.php",
            cache: false,
            type: 'POST',
            data:{orderdispatch:1,orderid:orderid,adminid:adminid},
            success : function(data){
                if(data == '1'){
                    swal("Done!","Order Updated succesfully!","success");
                    $("#dispatch-card").load(location.href+" #dispatch-card>*","");
                }else{
                    toastr["danger"]("Error in Dispatch Order");
                }
            }
        });
    }else{
        swal("Cancelled","","error");
    } 
});
}
  


// function validateFileType() {
//   var fileName = document.getElementById("expFiles").value;
//   var idxDot = fileName.lastIndexOf(".") + 1;
//   var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
//   if (extFile != "jpg" || extFile != "pdf" || extFile != "jpeg" || extFile != "png") {
//             alert("Only jpg/jpeg and png files are allowed!"); 
//             $("#expFiles").val("");
//   }  
// }