
<!DOCTYPE html>
<html>
<style>
	@page {
             margin: 10px 10px;
    }
	table, td, div {
	  border:1px solid black;
	  border-collapse: collapse;
	  width:100%;
	  border-color: #e8e9eb;
	  padding: 3px;
    word-break: normal;
	}
	body{
		font-family: sans-serif;
		font-size: 10px;
	}

	th{
		
		border:1px solid black;
		border-collapse: collapse;
		width:100%;
  	border-color: #e8e9eb;
  	padding: 5px;
  	text-align:left; 
    white-space: nowrap;
	}
</style>
<body>
    <!-- <p style="text-align:center; font-size: 14px;margin-top: 1px;">Site Visit Report</p> -->
    <!-- TAX INVOICE DETAILS HEADER -->
    <table style="margin-top: 0px;margin-bottom: 0px;">
        <tr>
            

            <td colspan="4" style="color: rgb(51,51,51);border-left: none; width: 150%; text: center">
 
                <h2 style='text-align:center;font-size:17px;line-height:12px;margin:1px;padding:0;'>
                Ashwattha Design Studio
                </h2>
            </td>

            <td  rowspan="2" style='padding:3px;vertical-align:middle;border-left: none;width: 20%;text-align:center'>
            <img src='{{asset("files/company/logo.png")}}' width="100" height="100"/>
            </td>
        </tr>
        <tr  style="border-bottom: none; border-top: none;">
            <td colspan="4" style="width: 150%;border-bottom: none; text: center">
                <p style='text-align:center;margin:5px;padding:0;'>
                URBAN DESIGN |ARCHITECTURE | LANDSCAPE | INTERIOR | GREEN CONSULTANCY </br>
                Reg. Office - Office No. S19, 2nd Floor, Bhosale Shinde Arcade , J.M. Road , Deccan, Pune - 411005. </br>
                Contact: +91 7620603634/8767286805, Email: studioashwattha@gmail.com </br>
                </p>
            </td>
        </tr>

        <tr  style="border-bottom: none; border-top: none;">
            <td colspan="5" style="width: 150%; text: center;border-bottom: none;">
                <h6 style='text-align:center;font-size:12px;line-height:12px;margin:1px;padding:0;'>
                Site Visit Report
                </h6>
            </td>
        </tr>

        <tr  style="border-bottom: none; border-top: none;">
            <td style="width:px;"  colspan="2"> Project Title : <br/> <b>{{$sv_obj[0]->project_name}} </b></td>
            <td style="width:px;" colspan="2"> Name Of Contractor : <br/> <b>{{$sv_obj[0]->contractor}} </b></td>
            <td style="width:px;"> Site Visit No : <br/> <b> </b></td>

            <!-- <td style="width:px;"> Stage Of Construction :<br/> <b>  </b></td> -->
            <!-- <td style="width:px;"> Site Visit Done by :<br/> <b>  </b></td> -->
        </tr>
        <tr style="border-bottom: none; border-top: none;">
            <td style="width:px;"> Stage Of Construction :<br/> <b>{{$sv_obj[0]->stage_contr}}  </b></td>
            <td style="width:px;" > Site Visit Done by :<br/> <b>{{$sv_obj[0]->name}}  </b></td>
            <td style="width:px;"> Date : <br/> <b> {{$sv_obj[0]->vdate}} </b></td>
            <td style="width:px;" colspan="2"> <br/> <b>  </b></td>
            
        </tr>
        
    </table>

    <table style='margin-top: 0px;'>
        <tr>
            <th  style="width:60px;text-align:center;">Sr.No</th>
            <th  style="white-space:wrap;text-align:center;"> Instruction </th>
            <th  style="width:120px;text-align:center;">Action Required from</th>
            
        </tr>
        <?php $j = 0;?>
        @foreach($data as $d)
        <tr style="border-bottom: none; border-top: none;">
            <td style="width: ;text-align:center;">{{++$j}}</td>
            <td style="width: ;text-align:center;">{{$d->instructions}}</td>          
            <td style="width: ;text-align:center;">{{$d->act_req_form}}</td>
        </tr>
        @endforeach
    </table>    
    <p style="text-align:center;font-size: 9px;">( This is computer generated Site Visit Report. )</p>
</body>
</html>