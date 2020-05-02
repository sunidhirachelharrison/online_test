<?php
    
    include("DB_connect.php");
    if(isset($_POST['btn_number']))
    {
        $btn_number = $_POST['btn_number'];
        $btn_color = $_POST['btn_color'];
        $rollno = $_POST['rollno'];
        
        
        $q1="SELECT * FROM state WHERE S_Enrollment_No='".$rollno."'";
        $row=mysqli_query($con,$q1);
        $fetch=mysqli_fetch_assoc($row);
        
        $selected_btn_field="";
        $unselected_field=array();
//        $unselected_field2="";
//        $unselected_field3="";
        if($btn_color=="red")
        {
            $selected_btn_field="S_Red_Btns";
            $unselected_field=["S_Green_Btns","S_Yellow_Btns","S_Purple_Btns"];
//            $unselected_field2=;
//            $unselected_field3=;
        }
        else if($btn_color=="green")
        {
            $selected_btn_field="S_Green_Btns";
            $unselected_field=["S_Red_Btns","S_Yellow_Btns","S_Purple_Btns"];
//            $unselected_field1="";
//            $unselected_field2="";
//            $unselected_field3="";
        }
        else if($btn_color=="yellow")
        {
            $selected_btn_field="S_Yellow_Btns";
            $unselected_field=["S_Red_Btns","S_Green_Btns","S_Purple_Btns"];
//            $unselected_field1="";
//            $unselected_field2="";
//            $unselected_field3="";
        }
        else if($btn_color=="purple")
        {
            $selected_btn_field="S_Purple_Btns";
            $unselected_field=["S_Red_Btns","S_Green_Btns","S_Yellow_Btns"];
//            $unselected_field1="";
// $unselected_field2="";
// $unselected_field3="";
        }
        $val=$fetch[$selected_btn_field];
        $val1=$fetch[$unselected_field[0]];
        $val2=$fetch[$unselected_field[1]];
        $val3=$fetch[$unselected_field[2]];
        $values_array=[$val1,$val2,$val3];
        
        
        
        if($val==null||$val==" ")
        {
            $val=$btn_number;
        }
        else
        {
            $val=str_replace("+"," ",$val);
            $val=explode(" ",$val);
            $val=array_diff($val, array($btn_number));    //removing btn_number from previous color fields
            //add + and convert array to string sequence
            $val=implode("+",$val);   //converting array back to string sequence separated by +

            
            $val=$val."+".$btn_number;  //adding btn_number to newly marked btn color fields
        }
        
        
        $var_array1=str_replace("+"," ",$val1);
        $var_array1=explode(" ",$var_array1);
        $var_array1=array_diff($var_array1, array($btn_number));    //removing btn_number from previous color fields
        //add + and convert array to string sequence
        $var_array1=implode("+",$var_array1);   //converting array back to string sequence separated by +
        
        $var_array2=str_replace("+"," ",$val2);
        $var_array2=explode(" ",$var_array2);
        $var_array2=array_diff($var_array2, array($btn_number));    //removing btn_number from previous color fields
        $var_array2=implode("+",$var_array2);   //converting array back to string sequence separated by +
        
        $var_array3=str_replace("+"," ",$val3);
        $var_array3=explode(" ",$var_array3);
        $var_array3=array_diff($var_array3, array($btn_number));    //removing btn_number from previous color fields
        $var_array3=implode("+",$var_array3);   //converting array back to string sequence separated by +
        $variables_array=[$var_array1,$var_array2,$var_array3];
        
        
        $i=0;
        foreach($unselected_field as $db_field)
        {
            $q2="UPDATE state SET ".$db_field."='".$variables_array[$i]."' WHERE S_Enrollment_No='".$rollno."'";
                
        
            $r=mysqli_query($con,$q2);
            if(!($r))
            {
    //            echo '<script>alert("Failed to update btn color info!);</script>';
            }
            else
            {
    //            echo '<script>alert("Success to update button color info!);</script>';

            }
            $i++;
        }
        
        $q3="UPDATE state SET ".$selected_btn_field."='".$val."' WHERE S_Enrollment_No='".$rollno."'";
        
        $r3=mysqli_query($con,$q3);
            if(!($r3))
            {
    //            echo '<script>alert("Failed to update btn color info!);</script>';
            }
            else
            {
    //            echo '<script>alert("Success to update button color info!);</script>';

            }
        
    }


?>
