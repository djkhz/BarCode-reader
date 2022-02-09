<?php 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>

<body>
  <!-- <button onclick="myScan()">Start Scan</button> -->
  
  <p id="code">code will appear here</p>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="exif.min.js"></script>
  <script src="BarcodeScanner.min.js"></script>
  <script src="app.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>

  <script>
       // Get all data
    //    axios.get('https://sheetdb.io/api/v1/qqfue73y5hqk1')
    // .then( response => {
    //     console.log(response.data);
    // });

    // // Get 10 results starting from 20
    // axios.get('https://sheetdb.io/api/v1/58f61be4dda40?limit=10&offset=20')
    // .then( response => {
    //     console.log(response.data);
    // });

    // // Get all data sorted by name in ascending order
    // axios.get('https://sheetdb.io/api/v1/58f61be4dda40?sort_by=name&sort_order=asc')
    // .then( response => {
    //     console.log(response.data);
    // });
    // function myScan() {
      var resultElement = document.getElementById('code')
    setupLiveReader(resultElement)
    // }
  </script>
</body>

</html>
