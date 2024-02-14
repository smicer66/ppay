<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{{--{!! HTML::style('css/questionstemplate.css') !!}--}}
<table>
    <tr>
        <td colspan="10" style="font-size:20px; font-weight:bold">BATCH ACCOUNT CREATION</td>
    </tr>
    @if($customer!=null)
        <tr class="info">
            <td colspan="1" style="font-weight: bold">CORPORATE ACCOUNT HOLDER</td>
            <td colspan="9">{{strtoupper($customer->lastName)}} {{$customer->firstName}} {{$customer->otherName}}</td>
        </tr>
        <tr class="info">
            <td colspan="1" style="font-weight: bold">PRIMARY ACCOUNT HOLDER</td>
            <td colspan="9">{{$account->accountIdentifier}}</td>
        </tr>
    @else
        <tr class="info">
            <td colspan="1" style="font-weight: bold">HELP GUIDE:</td>
            <td colspan="9">Read the Help Info tips to assist in filling the template</td>
        </tr>
        <tr class="info">
            <td colspan="1" style="font-weight: bold"></td>
            <td colspan="9"></td>
        </tr>
    @endif

    <tr>
        <td>&nbsp;</td>
        <td colspan="9" style="color:  #ff0084;"><b>HELP INFO: </b>OPEN EWALLET - indicate Yes or No. </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="9" style="color:  #ff0084;"><b>HELP INFO: </b>OPEN MOBILE MONEY - indicate Yes or No. </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="9" style="color:  #ff0084;"><b>HELP INFO: </b>OPEN AMOUNT - indicates the base account amount. Provide only numberic values, no commas</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="9" style="color:  #ff0084;"><b>HELP INFO: </b>Start Making Entries From Cell A11</td>
    </tr>
    <tr>
        <td style="width: 10px;">&nbsp;</td>
    </tr>
    <tr class="info header">
        <td style="width: 40px;"><b>FIRST NAME</b></td><!--0-->
        <td style="width: 40px"><b>LAST NAME</b></td><!--1-->
        <td style="width: 40px"><b>OTHER NAME</b></td><!--2-->
        <td style="width: 40px"><b>ADDRESS LINE 1</b></td><!--3-->
        <td style="width: 40px"><b>ADDRESS LINE 2</b></td><!--4-->
        <td style="width: 40px"><b>CONTACT EMAIL</b></td><!--5-->
        <td style="width: 40px"><b>ALTERNATIVE CONTACT EMAIL</b></td><!--6-->
        <td style="width: 40px"><b>CONTACT MOBILE</b></td><!--7-->
        <td style="width: 40px"><b>ALTERNATIVE CONTACT MOBILE</b></td><!--8-->
        <td style="width: 40px"><b>DATE OF BIRTH</b></td><!--9-->
        <td style="width: 40px"><b>GENDER</b></td><!--10-->
        <td style="width: 40px"><b>NAME ON CARD</b></td><!--11-->
        <td style="width: 40px"><b>ACCOUNT TYPE</b></td><!--12-->
        <td style="width: 40px"><b>OPENING AMOUNT</b></td><!--13-->
        <td style="width: 40px"><b>OPEN EWALLET</b></td><!--14-->
        <td style="width: 40px"><b>OPEN MOBILE MONEY</b></td><!--15-->
    </tr>

    <tbody>
    <tr>
        <td class="text" style="background-color:#C4DBFD; border:#666666 1px solid">Susan</td>
        <td class="text" style="background-color:#C4DBFD">Hawkins</td>
        <td class="text" style="background-color:#C4DBFD">Jennifer</td>
        <td class="text" style="background-color:#C4DBFD">120 Randy Close</td>
        <td class="text" style="background-color:#C4DBFD">Off St Louis Road, Northmead, Lusaka</td>
        <td class="text" style="background-color:#C4DBFD">hawkins.jennifer@testemail.com</td>
        <td class="text" style="background-color:#C4DBFD">hawkins.jennifer1@testemail.com</td>
        <td class="text" style="background-color:#C4DBFD">260803000000</td>
        <td class="text" style="background-color:#C4DBFD">260803000001</td>
        <td class="text" style="background-color:#C4DBFD">1980-12-30</td>
        <td class="text" style="background-color:#C4DBFD">FEMALE</td>
        <td class="text" style="background-color:#C4DBFD">Hawkins Jennifer</td>
        <td class="text" style="background-color:#C4DBFD">SAVINGS</td>
        <td class="text" style="background-color:#C4DBFD">2000</td>
        <td class="text" style="background-color:#C4DBFD">Yes</td>
        <td class="text" style="background-color:#C4DBFD">Yes</td>
    </tr>
    <tr>
        <td class="text" style="background-color:#C4DBFD; border:#666666 1px solid">Paul</td>
        <td class="text" style="background-color:#C4DBFD">Phillips</td>
        <td class="text" style="background-color:#C4DBFD">Zamari</td>
        <td class="text" style="background-color:#C4DBFD">10 Friends Street, Northmead</td>
        <td class="text" style="background-color:#C4DBFD">Lusaka, Zambia</td>
        <td class="text" style="background-color:#C4DBFD">paul.phillips@testemail.com</td>
        <td class="text" style="background-color:#C4DBFD">paul.phillips1@testemail.com</td>
        <td class="text" style="background-color:#C4DBFD">260803000000</td>
        <td class="text" style="background-color:#C4DBFD">260803000001</td>
        <td class="text" style="background-color:#C4DBFD">1974-11-25</td>
        <td class="text" style="background-color:#C4DBFD">MALE</td>
        <td class="text" style="background-color:#C4DBFD">Paul Phillips Zamari</td>
        <td class="text" style="background-color:#C4DBFD">CURRENT</td>
        <td class="text" style="background-color:#C4DBFD">5400</td>
        <td class="text" style="background-color:#C4DBFD">Yes</td>
        <td class="text" style="background-color:#C4DBFD">No</td>
    </tr>
    </tbody>
</table>
</html>