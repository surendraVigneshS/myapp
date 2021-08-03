
function inWords (num) {
    var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
    var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]])  : ' ';
    return str;
}

document.getElementById('amount').onkeyup = function () { 
    $('#amountWords').val(inWords($('#amount').val()));
};



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

$(function() {  
      
    document.querySelector('#changeimage').addEventListener("change", previewImages);  
});  
