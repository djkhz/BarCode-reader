<?php 
?>

<html>
<head>
    <title>Html-Qrcode Demo</title>

<style>
/* .vertical {
  display: -ms-grid;
  -ms-grid-rows: auto auto;
  -ms-grid-columns: auto auto;
  display: grid;
  grid-template-columns: min-content min-content;
  grid-template-rows: auto auto;
  grid-template-areas:
    "caption caption"
    "head body";
}
.vertical thead {
  grid-area: head;
  display: flex;
  flex-shrink: 0;
  min-width: min-content;
  -ms-grid-row: 2;
  -ms-grid-column: 1;
}
.vertical tbody {
    grid-area: body;
    display: flex;
  -ms-grid-row: 2;
  -ms-grid-column: 2;
}
.vertical tr {
  display: flex;
  flex-direction: column;
  min-width: min-content;
  flex-shrink: 0;
}
.vertical td, .vertical th {
  display: block;
}
.vertical caption {
  display: block;
  -ms-grid-row: 1;
  -ms-grid-column: 1;
  -ms-grid-column-span: 2;
  grid-area: caption; 
} */

/* Visual styling */
table { border-collapse: collapse; }
table td {
  border: 1px solid black; 
}
table th {
  border: 1px solid black;
  background-color: grey;
  color: white;
}
</style>
<body>
    <div id="qr-reader" style="width:500px"></div>
    <div id="qr-reader-results"></div>
    <div id="qr-reader-details"></div>
</body>
<script src="/html5-qrcode.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
<!-- <script type="text/javascript" 
            src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
    </script> -->
<script>
  function transpose(mat) {
                for (var i = 0; i < mat.length; i++) {
                    for (var j = 0; j < i; j++) {
                        const tmp = mat[i][j];
                        mat[i][j] = mat[j][i];
                        mat[j][i] = tmp;
                    }
                }
            }
            
//   function transpose(values) {
//     if (!Array.isArray(values))
//         throw new Error("`values` must be an array");

//     if (values.length === 0)
//         return {};

//     const keys = Object.keys(values[0]);
//     const transposed = {
//         data: {},
//         count: values.length,
//     };

//     keys.forEach(key => {
//         transposed.data[key] = [];

//         values.forEach(value => {
//             transposed.data[key].push(value[key]);
//         });
//     });

//     return transposed;
// }
//////////////////////////////
// var detialContainer = document.getElementById('qr-reader-details');
// var decodedText= '8850124034519';
// // axios.get('https://sheetdb.io/api/v1/qqfue73y5hqk1/search?ID=' + decodedText)
// //     .then( response => {
      
// //       detialContainer.innerHTML="asdasd";
// //         console.log(response.data);
        
// //     });
// var xhr = new XMLHttpRequest();
// xhr.open("GET", "https://sheetdb.io/api/v1/qqfue73y5hqk1/search?ID=" + decodedText, true);
// xhr.onload = function (e) {
//   if (xhr.readyState === 4) {
//     if (xhr.status === 200) {
//       console.log(xhr.responseText);
//       var response = JSON.parse(xhr.responseText);
//       detialContainer.appendChild(buildHtmlTable(response));
//       // console.log("Temperature(K): " + response.main.temp);
//     } else {
//       console.error(xhr.statusText);
//     }
//   }
// };
// xhr.onerror = function (e) {
//   console.error(xhr.statusText);
// };
// xhr.send(null);
// $(document).ready(function () {
			
//   $.ajax({
//     type: "GET",
//     url: "https://sheetdb.io/api/v1/qqfue73y5hqk1/search?ID=8992304033919",
//     success: function(data){alert("yeah");},
//     error: function(){alert("fail..");},
//     dataType:"xml",
// });

  // $.get("https://sheetdb.io/api/v1/qqfue73y5hqk1/search?ID=8992304033919", function(data, status){
      
  //     // var response = JSON.parse(data);
  //     $( ".qr-reader-details" ).html( data );
  //     alert( "Load was performed." );
      
  //     console.log(data);
  //   });

 
var _table_ = document.createElement('table'),
  _tr_ = document.createElement('tr'),
  _th_ = document.createElement('th'),
  _td_ = document.createElement('td');
  _table_.className = "vertical";

// Builds the HTML Table out of myList json data from Ivy restful service.
function buildHtmlTable(arr) {
  var table = _table_.cloneNode(false),
    columns = addAllColumnHeaders(arr, table);
  for (var i = 0, maxi = arr.length; i < maxi; ++i) {
    var tr = _tr_.cloneNode(false);
    for (var j = 0, maxj = columns.length; j < maxj; ++j) {
      var td = _td_.cloneNode(false);
      cellValue = arr[i][columns[j]];
      td.appendChild(document.createTextNode(arr[i][columns[j]] || ''));
      tr.appendChild(td);
    }
    table.appendChild(tr);
  }
  return table;
}

// Adds a header row to the table and returns the set of columns.
// Need to do union of keys from all records as some records may not contain
// all records
function addAllColumnHeaders(arr, table) {
  var columnSet = [],
    tr = _tr_.cloneNode(false);
  for (var i = 0, l = arr.length; i < l; i++) {
    for (var key in arr[i]) {
      if (arr[i].hasOwnProperty(key) && columnSet.indexOf(key) === -1) {
        columnSet.push(key);
        var th = _th_.cloneNode(false);
        th.appendChild(document.createTextNode(key));
        tr.appendChild(th);
      }
    }
  }
  table.appendChild(tr);
  return columnSet;
}

///////////////////////////////////

    function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete" || document.readyState === "interactive") {
            // call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    docReady(function () {
        var resultContainer = document.getElementById('qr-reader-results');
        var detialContainer = document.getElementById('qr-reader-details');
        
        var lastResult, countResults = 0;
        

        
        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                // Handle on success condition with the decoded message.
                console.log(`Scan result ${decodedText}`, decodedResult);
            }
            resultContainer.innerHTML = decodedText;
      axios.get('https://sheetdb.io/api/v1/qqfue73y5hqk1/search?ລະຫັດ=' + decodedText)
          .then( response => {
            detialContainer.innerHTML =""
            

// const products = [
//     { id: 1, name: "Building Microservices", price: 39.49 },
//     { id: 2, name: "Kubernetes Patterns", price: 28.99 },
//     { id: 3, name: "Clean Code", price: 30.99 },
// ];
// var array =response.data[0];
// transpose(array);
// // transpose(array);
//                 var newarry = "[ [ " + array[0] + " ] ], [ [ "
//                         + array[1] + " ] ], [ [ " + array[2] + " ] ]";
                   
// console.log(transposed);
      detialContainer.appendChild(buildHtmlTable(response.data));
    //   $("table").each(function() {
    //     var $this = $(this);
    //     var newrows = [];
    //     $this.find("tr").each(function(){
    //         var i = 0;
    //         $(this).find("td").each(function(){
    //             i++;
    //             if(newrows[i] === undefined) { newrows[i] = $("<tr></tr>"); }
    //             newrows[i].append($(this));
    //         });
    //     });
    //     $this.find("tr").remove();
    //     $.each(newrows, function(){
    //         $this.append(this);
    //     });
    // });
        // console.log(response.data);
        
    });
    
        }
        
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);
    });
    
  // });
</script>
</head>
</html>

