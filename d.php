<?php


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script>
        //var x = 300;
        var x = "";
        for (i = 0; i < 13; i++) {
            if (localStorage.getItem('myAnswers' + i) != null) {
                x = x + " " + localStorage.getItem('myAnswers' + i) + " " + i;
                //alert(" " + localStorage.getItem('myAnswers' + i));
            } else if (localStorage.getItem('myAnswers' + i + "1") != null) {
                {
                    x = x + " " + localStorage.getItem('myAnswers' + i + i) + " " + i;
                }
            }
            alert(x);

            //        var key = "x";
            //        Storage.prototype.getObject = function(key) {
            //            var val = JSON.parse(this.getItem(key));
            //            alert(val);
            //            return JSON.parse(this.getItem(key));
            //        }
            // alert(val);

    </script>


</head>

<body>


    <script type="text/javascript">
        //        var personObject = {
        // name: "Peter",
        // age: 18,
        // married: false
        // };
        //
        // // Convert the person object into JSON string and save it into storage
        // window.localStorage.setItem('personObject', JSON.stringify(personObject));
        //
        // // Retrieve the JSON string
        // var jsonString = window.localStorage.getItem('personObject');
        //
        // // Parse the JSON string back to JS object
        // var retrievedObject = JSON.parse(jsonString);
        // console.log(retrievedObject);
        //
        // // Accessing individual values
        // document.write(console.log(retrievedObject.name)); // Prints: Peter
        // document.write(console.log(retrievedObject.age)); // Prints: 18
        // document.write(console.log(retrievedObject.married)); // Prints: false

    </script>


</body>

</html>
