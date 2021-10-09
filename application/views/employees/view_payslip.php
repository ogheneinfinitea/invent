<!DOCTYPE html>
<html  lang="en">

    <!-- Mirrored from cforms-elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 02 Mar 2017 12:11:32 GMT -->
    <head>
        <style>
            /* Loading Spinner */
            .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
            td{padding: 2px !important;}
        </style>

        <meta charset="UTF-8">
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
        <title> Facteezo: View Payslip</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Favicons -->

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url() ?>assets/images/icons/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url() ?>assets/images/icons/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url() ?>assets/images/icons/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?= base_url() ?>assets/images/icons/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="<?= base_url() ?>assets/images/icons/favicon.png">





        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets-minified/admin-all-demo.css">

        <!-- JS Core -->

        <script type="text/javascript" src="<?= base_url() ?>assets-minified/js-core.js"></script>

        <script type="text/javascript">
            $(window).load(function () {
                setTimeout(function () {
                    $('#loading').fadeOut(400, "linear");
                }, 300);
            });
        </script>

    </head>

    <body>
        <div id="sb-site">




            <!-- //////////////// Start Code from Here Add Account ////////////////////////////// -->

            <div id="page-wrapper">
                <?php $this->load->view("components/header") ?>
                <?php $this->load->view("components/sidebar") ?>
                <div id="page-content-wrapper">
                    <div id="page-content">
                        <div class="container">
                            <!-- jQueryUI Spinner -->
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/spinner/spinner.js"></script>
                            <script type="text/javascript">
            /* jQuery UI Spinner */

            $(function () {
                "use strict";
                $(".spinner-input").spinner();
            });
                            </script>

                            <!-- jQueryUI Autocomplete -->

                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/autocomplete/autocomplete.js"></script>
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/autocomplete/menu.js"></script>
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/autocomplete/autocomplete-demo.js"></script>

                            <!-- Touchspin -->

<!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/widgets/touchspin/touchspin.css">-->
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/touchspin/touchspin.js"></script>
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/touchspin/touchspin-demo.js"></script>

                            <!-- Input switch -->

<!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/widgets/input-switch/inputswitch.css">-->
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/input-switch/inputswitch.js"></script>
                            <script type="text/javascript">
            /* Input switch */
            $(function () {
                "use strict";
                $('.input-switch').bootstrapSwitch();
            });
                            </script>

                            <!-- Textarea -->
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/textarea/textarea.js"></script>
                            <script type="text/javascript">
            /* Textarea autoresize */

            $(function () {
                "use strict";
                $('.textarea-autosize').autosize();
            });
                            </script>

                            <!-- Multi select -->

<!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/widgets/multi-select/multiselect.css">-->
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/multi-select/multiselect.js"></script>
                            <script type="text/javascript">
            /* Multiselect inputs */

            $(function () {
                "use strict";
                $(".multi-select").multiSelect();
                $(".ms-container").append('<i class="glyph-icon icon-exchange"></i>');
            });
                            </script>

                            <!-- Uniform -->

<!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/widgets/uniform/uniform.css">-->
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/uniform/uniform.js"></script>
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/uniform/uniform-demo.js"></script>

                            <!-- Chosen -->

<!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/widgets/chosen/chosen.css">-->
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/chosen/chosen.js"></script>
                            <script type="text/javascript" src="<?= base_url() ?>assets/widgets/chosen/chosen-demo.js"></script>





                            <!-- ////////////////Account Haeding/ And Add Page///////////////////////////// -->
                            <button class="btn btn-primary" onclick="PrintMe();">Print</button>
                            <div id="page-title">
                                <h2 class=" text-center font-bold">Information for Employee Payslip </h2>
                            </div>
                            <!-- ////////////////Panel Start///////////////////////////// -->
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="example-box-wrapper">
                                        <div class="tab-pane pad0A fade active in" id="tab-example-4">
                                            <div class="" id="PrintDiv">    
                                                <p><h4 class="text-center font-bold">Employee Details</h4></p>  
                                                <table width="100%" >
                                                    <tr>
                                                        <td><b>Date</b></td>
                                                        <td align="right"><?php echo date("d-M-Y", strtotime($employee_ledger[0]->ledger_date)) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Salary Month</b></td>
                                                        <td align="right" id="month"><?= $employee_ledger[0]->month == '01' ? 'January' : '' ?>
                                                            <?= $employee_ledger[0]->month == '02' ? 'February' : '' ?>
                                                            <?= $employee_ledger[0]->month == '03' ? 'March' : '' ?>
                                                            <?= $employee_ledger[0]->month == '04' ? 'April' : '' ?>
                                                            <?= $employee_ledger[0]->month == '05' ? 'May' : '' ?>
                                                            <?= $employee_ledger[0]->month == '06' ? 'June' : '' ?>
                                                            <?= $employee_ledger[0]->month == '07' ? 'July' : '' ?>
                                                            <?= $employee_ledger[0]->month == '08' ? 'August' : '' ?>
                                                            <?= $employee_ledger[0]->month == '09' ? 'September' : '' ?>
                                                            <?= $employee_ledger[0]->month == '10' ? 'October' : '' ?>
                                                            <?= $employee_ledger[0]->month == '11' ? 'November' : '' ?>
                                                            <?= $employee_ledger[0]->month == '12' ? 'December' : '' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Salary Year</b></td>
                                                        <td align="right" id="year"><?php for ($i = 0; $i < 5; $i++) { ?>
                                                        <?= $employee_ledger[0]->year == date("Y", strtotime('+' . $i . ' year')) ? date("Y", strtotime('+' . $i . ' year')) : '' ?>
                                                            <?php } ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Employee Name :</b></td>
                                                        <td align="right"><?php foreach ($employees as $employee) { ?>
                                                            <?= $employee_ledger[0]->employee_id == $employee->employee_id ? $employee->emp_name . '<input type="hidden" id="emp_name" value="' . $employee->employee_id . '"/>' : '' ?>
                                                            <?php } ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Employee ID</b></td>
                                                        <td align="right" id="emp_unique_id"></td>
                                                    </tr>
                                                </table>

                                                <p><h4 class="text-center font-bold">Salary Details</h4></p>
                                                <table class="table-hover"  width="100%" border="1">
                                                    <tr>
                                                        <th class="text-center" style="background: #e3e4e5"><b>Earning</b></th>
                                                        <th class="text-center" style="background: #e3e4e5"><b>Deduction</b></th>
                                                    </tr>
                                                    <tr>
                                                        <td id="allowance" style="width:50%" >
                                                            <table width="100%" >
                                                                <tr>
                                                                    <td><b>Basic Salary</b></td>
                                                                    <td id="emp_basic_salary" align="right" ></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td id="deduction" style="width:50%">
                                                            <table width="100%" >
                                                                <tr>
                                                                    <td><b>Advance Amount</b></td>
                                                                    <td id="advance" align="right" ></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr> 
                                                        <td>
                                                            <?php
                                                             $html = "";
                                                               $id = 0;
                                                                 foreach ($employee_ledger_detail as $inv_item) {
                                                                  if ($inv_item->type == 'Allowance') {
            //                                                        print_r($inv_item->qty);
                                                                   $html .= '<table width="100%"  class="allo" id="allo' . $id . '"><tr><td>';
                                                                    $html .= '<div id="div_all_name' . $id . '" class="input-group"><div   id="all_name' . $id . '"  >' . $inv_item->detail_name . '</div></div></td>';
                                                                    $html .= '<td align="right"><div id="div_all_amount' . $id . '" class="input-group"><div id="all_amount' . $id . '" class=" allo_amount" >' . $inv_item->detail_amount . '</div></div></td>';
                                                                    $html .= '</tr></table>';
                                                                    $id++;
                                                                        }
                                                                    }
                                                                    echo $html;
                                                                    ?> 
                                                        </td>
                                                        <td>
                                                            
                                                                        <?php
                                                            $html = "";
                                                            $id = 0;
                                                            foreach ($employee_ledger_detail as $inv_item) {
                                                                if ($inv_item->type == 'Deduction') {
//                                                        print_r($inv_item->qty);
                                                                    $html .= '<table width="100%"  class="dedu" id="dedu' . $id . '"><tr><td>';
                                                                    $html .= '<div id="div_ded_name' . $id . '" class="input-group"><div  id="ded_name' . $id . '"  >' . $inv_item->detail_name . '</div></div></td>';
                                                                    $html .= '<td align="right"><div id="div_ded_amount' . $id . '" class="input-group"><div  id="ded_amount' . $id . '" class="ded_amount" >' . $inv_item->detail_amount . '</div></div></td>';
                                                                    $html .= ' </tr></table>';

                                                                    $id++;
                                                                }
                                                            }
                                                            echo $html;
                                                            ?>
                                                        </td>  
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <table width="100%"  ><tr>
                                                                    <td><label class="control-label">Total Earning</label></td>
                                                                    <td align="right" id="total_earning"></td>
                                                                </tr>
                                                            </table>
                                                        </th>
                                                        <th>
                                                            <table width="100%"  ><tr>
                                                                    <td><label class="control-label">Total Deduction</label></td>
                                                                    <td align="right" id="total_deduction" ></td>
                                                                </tr>
                                                            </table>
                                                        </th>
                                                    </tr>
                                                </table>


                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="text-right" id="total" style="font-size: 18px; font-weight: bold; color:#003eff;">Net Salary : &nbsp;&nbsp;
                                                            <span>0.00</span> 
                                                            <?= $this->session->userdata('currency_symbol') ?>
                                                            <input type="hidden" name="ledger_amount" id="ledger_amount" />
                                                        </div>
                                                    </div>   
                                                </div>
                                                
                                                </br>
                                                 </br>
                                                <table width="100%">
                                                <tr>
                                                    <td><label>---------------------------</label></td>
                                                    <td align="right">---------------------------</td>
                                                </tr>
                                                <tr>
                                                    <td><label >Manager signature</label></td>
                                                    <td align="right">Employee Signature</td>
                                                </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                                    <!-- ////////////////Panel End///////////////////////////// -->



                                    <!-- JS Demo -->
                                    <script type="text/javascript" src="<?= base_url() ?>assets-minified/admin-all-demo.js"></script>
                                    <script src="<?= base_url() ?>ckeditor/ckeditor.js"></script>
                                    <script>
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
//            CKEDITOR.replace('desc');
                                    </script>
                                    <!-- ////////////////Script Add Confirm & Validation Start///////////////////////////// -->
                                    <script>
                                        function  CalculateSubTotal(id = null) {
                                            var total = 0.00;
                                            var emp_basic_salary = $("#emp_basic_salary").html();
                                            var advance = $("#advance").html();
                                            if (emp_basic_salary == "") {
                                                emp_basic_salary = 0.00;
                                            }
                                            if (advance == "") {
                                                advance = 0.00;
                                            }
                                            total = emp_basic_salary - advance;
                                            var all_amount = 0.00;
                                            var ded_amount = 0.00;
                                            if ($(".allo_amount").length > 0) {
                                                $(".allo_amount").each(function () {
                                                    if ($(this).html()) {
                                                        all_amount += parseFloat($(this).html());
                                                    }
                                                });
                                            }
                                            if ($(".ded_amount").length > 0) {
                                                $(".ded_amount").each(function () {
                                                    if ($(this).html()) {
                                                        ded_amount += parseFloat($(this).html());
                                                    }
                                                });
                                            }
                                            $("#total_earning").html(parseFloat((all_amount)).toFixed(2));
                                            $("#total_deduction").html(parseFloat((ded_amount)).toFixed(2));
                                            total += all_amount;
                                            total = total - ded_amount;

                                            $('#total span').html(parseFloat((total)).toFixed(2));
                                            $("#ledger_amount").val(parseFloat((total)).toFixed(2));


                                        }
                                        function add_allowance() {
                                            var id = "0";
                                            $("#allowance div.allo").each(function () {
                                                id = "";
                                                var curr_prod = $(this).attr("id");
                                                curr_prod = curr_prod.replace("allo", "");
                                                id = parseInt(curr_prod) + 1;
                                            }
                                            );
                                            var html = '<div class="col-sm-12 allo" id="allo' + id + '">';
                                            html += '<div  class=" col-sm-5"><div id="div_all_name' + id + '" class="input-group"><input  type="text"  name="all_name[]" id="all_name' + id + '" class="form-control" placeholder="Allowance Name"></div></div>';
                                            html += '<div class="col-sm-5"><div id="div_all_amount' + id + '" class="input-group"><input type="number" onblur="setTwoNumberDecimal(this.id)" onkeyup="CalculateSubTotal();" step="0.01" name="all_amount[]" id="all_amount' + id + '" class="form-control allo_amount" placeholder="Allowance Amount"></div></div>';
                                            html += '<div class="col-sm-2"><div class="input-group"><button type="button"  onclick="DelAllo(' + id + ')" class="btn btn-danger cross" onkeydown="checkTabPress(event);">X</button></div></div> </div>';
//                                                    alert(html);
                                            $("#allowance").append(html);
//                                                    alert($("#product_name" + id).next("div").children("a").text());

                                        }
                                        function checkTabPress(e) {
                                            if (e.keyCode == 9) {
                                                add_allowance();
                                            }
                                        }
                                        function DelAllo(myid_prod) {
                                            myid_prod = "allo" + myid_prod;
                                            $("#" + myid_prod).remove();
                                        }
                                        function add_deduction() {
                                            var id = "0";
                                            $("#deduction div.dedu").each(function () {
                                                id = "";
                                                var curr_prod = $(this).attr("id");
                                                curr_prod = curr_prod.replace("dedu", "");
                                                id = parseInt(curr_prod) + 1;
                                            }
                                            );
                                            var html = '<div class="col-sm-12 dedu" id="dedu' + id + '">';
                                            html += '<div  class=" col-sm-5"><div id="div_ded_name' + id + '" class="input-group"><input  type="text"  name="ded_name[]" id="ded_name' + id + '" class="form-control" placeholder="Deduction Name"></div></div>';
                                            html += '<div class="col-sm-5"><div id="div_ded_amount' + id + '" class="input-group"><input type="number" onblur="setTwoNumberDecimal(this.id)" onkeyup="CalculateSubTotal();" step="0.01" name="ded_amount[]" id="ded_amount' + id + '" class="form-control ded_amount" placeholder="Deduction Amount"></div></div>';
                                            html += '<div class="col-sm-2"><div class="input-group"><button type="button"  onclick="DelDedu(' + id + ')" class="btn btn-danger cross" onkeydown="checkTabPress(event);">X</button></div></div> </div>';
//                                                    alert(html);
                                            $("#deduction").append(html);
//                                                    alert($("#product_name" + id).next("div").children("a").text());

                                        }
                                        function checkTabPressDedu(e) {
                                            if (e.keyCode == 9) {
                                                add_deduction();
                                            }
                                        }
                                        function DelDedu(myid_prod) {
                                            myid_prod = "dedu" + myid_prod;
                                            $("#" + myid_prod).remove();
                                        }
                                        function ConfirmAdd() {
                                            var emp_name = $("#emp_name").html();
                                            var month = $("#month").html();
                                            var year = $("#year").html();
                                            var err = false;
                                            if (emp_name == "" || emp_name == null) {
                                                $("#emp_name_chosen").css("border", "1px solid red");
                                                err = true;
                                            }
                                            if (month == "" || month == null) {
                                                $("#month_chosen").css("border", "1px solid red");
                                                err = true;
                                            }
                                            if (year == "" || year == null) {
                                                $("#year_chosen").css("border", "1px solid red");
                                                err = true;
                                            }
                                            $(".allo").each(function (i) {
                                                var all_name = $(this).find('[id^=all_name]').html();
                                                var all_amount = $(this).find('[id^=all_amount]').html();
                                                if (all_name == null || all_name == 0) {
                                                    $("#all_name" + i).css("border", "1px solid red");
                                                    err = true;
                                                }
                                                if (all_amount == null || all_amount == 0) {
                                                    $("#all_amount" + i).css("border", "1px solid red");
                                                    err = true;
                                                }
                                            });
                                            $(".dedu").each(function (i) {
                                                var ded_name = $(this).find('[id^=ded_name]').html();
                                                var ded_amount = $(this).find('[id^=ded_amount]').html();
                                                if (ded_name == null || ded_name == 0) {
                                                    $("#ded_name" + i).css("border", "1px solid red");
                                                    err = true;
                                                }
                                                if (ded_amount == null || ded_amount == 0) {
                                                    $("#ded_amount" + i).css("border", "1px solid red");
                                                    err = true;
                                                }
                                            });

                                            if (err === true) {
                                                return false;
                                            } else {
                                                $("#SubmitAdd").submit();
                                            }
                                        }
                                        function setTwoNumberDecimal(id) {

                                            $("#" + id).val(parseFloat($("#" + id).html()).toFixed(2));
                                        }
                                        function GetEmployeeUniqueID(employee_id) {
                                            $("#emp_unique_id").html(employee_id);
                                        }
                                        function GetBasicSalary(emp_id) {
                                            $.post("<?= base_url() ?>employees/GetBasicSalary", {employee_id: emp_id})
                                                    .done(function (data) {
//                                                    alert(data);
                                                        $("#emp_basic_salary").html(data);

                                                    });
                                            CalculateSubTotal();

                                        }
                                        function GetAdvance(emp_id, month, year) {
                                            var emp_id = $("#emp_name").val();
                                            var month = parseInt($("#month").html());
                                            var year = parseInt($("#year").html());

                                            if (emp_id != "" && month != "" && year != "") {
                                                $.post("<?= base_url() ?>employees/GetAdvance", {employee_id: emp_id, month: month, year: year})
                                                        .done(function (data) {
//                                                            alert(data);
                                                            $("#advance").html(data);
                                                            CalculateSubTotal();
                                                        });
                                            } else {
                                                CalculateSubTotal();
                                                return false;
                                            }

                                        }

                                        function RevertValidation() {
                                            var name = $("#name").html();
                                            var account_number = $("#account_number").html();
                                            var phone_number = $("#phone_number").html();
                                            var account_address = $("#account_address").html();
                                            var opening_balance = $("#opening_balance").html();
                                            var err = false;
                                            if (name !== "" & name !== null) {
                                                $("#name").css("border", "1px solid #dfe8f1");
                                                err = true;
                                            }
                                            if (account_number !== "" & account_number !== null) {
                                                $("#account_number").css("border", "1px solid #dfe8f1");
                                                err = true;
                                            }
                                            if (phone_number !== "" & phone_number !== null) {
                                                $("#phone_number").css("border", "1px solid #dfe8f1");
                                                err = true;
                                            }
                                            if (phone_number !== "" & phone_number !== null) {
                                                $("#phone_number").css("border", "1px solid #dfe8f1");
                                                err = true;
                                            }
                                            // if (account_address !== "" & account_address !== null) {
                                            //     $("#account_address").css("border", "1px solid #dfe8f1");
                                            //     err = true;
                                            // }
                                            if (opening_balance !== "" & opening_balance !== null) {
                                                $("#opening_balance").css("border", "1px solid #dfe8f1");
                                                err = true;
                                            }

                                        }
                                    </script>
                                    <script type="text/javascript" src="<?= base_url() ?>assets/widgets/datepicker/datepicker.js"></script>
                                    <script type="text/javascript">
                                        /* Datepicker bootstrap */

                                        $(function () {
                                            "use strict";
                                            $('.bootstrap-datepicker').bsdatepicker({
                                                format: 'mm-dd-yyyy'
                                            });
                                        });
                                        function PrintMe() {
                                            var printContents = document.getElementById('PrintDiv').innerHTML;
                                            var header = document.getElementById('page-title').innerHTML;



                                            var originalContents = document.body.innerHTML;
                                            document.body.innerHTML = header + printContents;

                                            window.print();

                                            document.body.innerHTML = originalContents;
                                        }
                                    </script>
                                    <!-- ////////////////Script Add Confirm & Validation End///////////////////////////// -->
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $("#ledger_date").bsdatepicker({
                                                format: 'mm-dd-yyyy'
                                            });

                                            $('#ledger_date').on('changeDate', function (ev) {
                                                $(this).bsdatepicker('hide');
                                            });
                                            GetEmployeeUniqueID(<?= $unique_id ?>);
                                            GetBasicSalary(<?= $employee_id ?>);
                                            GetAdvance(<?= $employee_id ?>,<?= $month ?>,<?= $year ?>);

                                        });
                                    </script>





                                </div>
                                </body>

                                <!-- Mirrored from agileui.com/demo/monarch/demo/admin-template/forms-elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 02 Mar 2017 12:11:42 GMT -->
                                </html>