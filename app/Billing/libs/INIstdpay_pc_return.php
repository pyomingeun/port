<?php
        require_once('libs/INIStdPayUtil.php');
        require_once('libs/HttpClient.php');

        $util = new INIStdPayUtil();

        try {

            //#############################
            // Receiving authentication result parameters.
            //#############################

            if (strcmp("0000", $_REQUEST["resultCode"]) == 0) {

                //############################################
                // 1.Setting the field values in the message (***Merchant need to set***)
                //############################################

                $mid        = $_REQUEST["mid"];
                $timestamp  = $util->getTimestamp();
                $charset    = "UTF-8";
                $format     = "JSON";
                $authToken  = $_REQUEST["authToken"];
                $authUrl    = $_REQUEST["authUrl"];
                $netCancel  = $_REQUEST["netCancelUrl"];
                $merchantData = $_REQUEST["merchantData"];

                //#####################
                // 2.create signature
                //#####################
                $signParam["authToken"] = $authToken;   // required
                $signParam["timestamp"] = $timestamp;   // required
                //  Generating signature data (sorting signParam alphabetically and concatenating in NVP format for hashing, automatically done by the module).
                $signature = $util->makeSignature($signParam);


                //#####################
                // 3.Generating the API request message.
                //#####################
                $authMap["mid"]        = $mid;       // required
                $authMap["authToken"]  = $authToken; // required
                $authMap["signature"]  = $signature; // required
                $authMap["timestamp"]  = $timestamp; // required
                $authMap["charset"]    = $charset;   // default=UTF-8
                $authMap["format"]     = $format;    // default=XML

                try {

                    $httpUtil = new HttpClient();

                    //#####################
                    // 4.Start API request
                    //#####################

                    $authResultString = "";
                    if ($httpUtil->processHTTP($authUrl, $authMap)) {
                        $authResultString = $httpUtil->body;

                    } else {
                        echo "Http Connect Error\n";
                        echo $httpUtil->errormsg;

                        throw new Exception("Http Connect Error");
                    }

                    //############################################################
                    //5.Handle the result of API communication(***merchant need to modify***)
                    //############################################################

                    $resultMap = json_decode($authResultString, true);


                } catch (Exception $e) {
                    //    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                    //####################################
                    // Error handling(***merchant need to modify***)
                    //####################################
                    //---- exception handling like the failure of save on db ----//
                    $s = $e->getMessage() . ' (Error code:' . $e->getCode() . ')';
                    echo $s;

                    //#####################
                    // Net Cancel API
                    //#####################

                    $netcancelResultString = ""; // Network cancel request API url(fixed. Prohibi arbitrary settings)
                    if ($httpUtil->processHTTP($netCancel, $authMap)) {
                        $netcancelResultString = $httpUtil->body;
                    } else {
                        echo "Http Connect Error\n";
                        echo $httpUtil->errormsg;

                        throw new Exception("Http Connect Error");
                    }

                    echo "<br/>## Response from Net Cancel API ##<br/>";

                    /*##XML output##*/
                    //$netcancelResultString = str_replace("<", "&lt;", $$netcancelResultString);
                    //$netcancelResultString = str_replace(">", "&gt;", $$netcancelResultString);

                    // Check the result of cancel request
                    echo "<p>". $netcancelResultString . "</p>";
                }
            } else {

            }
        } catch (Exception $e) {
            $s = $e->getMessage() . ' (Error code:' . $e->getCode() . ')';
            echo $s;
        }
?>
<!DOCTYPE html>
<html lang="ko">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>KG이니시스 결제샘플</title>
        <link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
    </head>

    <body class="wrap">

        <!-- 본문 -->
        <main class="col-8 cont" id="bill-01">
            <!-- 페이지타이틀 -->
            <section class="mb-5">
                <div class="tit">
                    <h2>일반결제</h2>
                    <p>KG이니시스 결제창을 호출하여 다양한 지불수단으로 안전한 결제를 제공하는 서비스</p>
                </div>
            </section>
            <!-- //페이지타이틀 -->


            <!-- 카드CONTENTS -->
            <section class="menu_cont mb-5">
                <div class="card">
                    <div class="card_tit">
                        <h3>PC 일반결제</h3>
                    </div>

                    <!-- 유의사항 -->
                    <div class="card_desc">
                        <h4>※ 유의사항</h4>
                        <ul>
                            <li>테스트MID 결제시 실 승인되며, 당일 자정(24:00) 이전에 자동으로 취소처리 됩니다.</li>
							<li>가상계좌 채번 후 입금할 경우 자동환불되지 않사오니, 가맹점관리자 내 "입금통보테스트" 메뉴를 이용부탁드립니다.<br>(실 입금하신 경우 별도로 환불요청해주셔야 합니다.)</li>
							<li>국민카드 정책상 테스트 결제가 불가하여 오류가 발생될 수 있습니다. 국민, 카카오뱅크 외 다른 카드로 테스트결제 부탁드립니다.</li>
                        </ul>
                    </div>
                    <!-- //유의사항 -->


                    <form name="" id="result" method="post" class="mt-5">
                    <div class="row g-3 justify-content-between" style="--bs-gutter-x:0rem;">

                        <label class="col-10 col-sm-2 gap-2 input param" style="border:none;">resultCode</label>
                        <label class="col-10 col-sm-9 reinput">
                            <?php echo @(in_array($resultMap["resultCode"] , $resultMap) ? $resultMap["resultCode"] : $_REQUEST["resultCode"] ) ?>
                        </label>

						<label class="col-10 col-sm-2 input param" style="border:none;">resultMsg</label>
                        <label class="col-10 col-sm-9 reinput">
                            <?php echo @(in_array($resultMap["resultMsg"] , $resultMap) ? $resultMap["resultMsg"] : $_REQUEST["resultMsg"] ) ?>
                        </label>

						<label class="col-10 col-sm-2 input param" style="border:none;">tid</label>
                        <label class="col-10 col-sm-9 reinput">
                            <?php echo @(in_array($resultMap["tid"] , $resultMap) ? $resultMap["tid"] : "null" ) ?>
                        </label>

						<label class="col-10 col-sm-2 input param" style="border:none;">MOID</label>
                        <label class="col-10 col-sm-9 reinput">
                            <?php echo @(in_array($resultMap["MOID"] , $resultMap) ? $resultMap["MOID"] : "null" ) ?>
                        </label>

						<label class="col-10 col-sm-2 input param" style="border:none;">TotPrice</label>
                        <label class="col-10 col-sm-9 reinput">
                            <?php echo @(in_array($resultMap["TotPrice"] , $resultMap) ? $resultMap["TotPrice"] : "null" ) ?>
                        </label>

						<label class="col-10 col-sm-2 input param" style="border:none;">goodName</label>
                        <label class="col-10 col-sm-9 reinput">
                            <?php echo @(in_array($resultMap["goodName"] , $resultMap) ? $resultMap["goodName"] : "null" ) ?>
                        </label>

						<label class="col-10 col-sm-2 input param" style="border:none;">applDate</label>
                        <label class="col-10 col-sm-9 reinput">
                            <?php echo @(in_array($resultMap["applDate"] , $resultMap) ? $resultMap["applDate"] : "null" ) ?>
                        </label>

						<label class="col-10 col-sm-2 input param" style="border:none;">applTime</label>
                        <label class="col-10 col-sm-9 reinput">
                            <?php echo @(in_array($resultMap["applTime"] , $resultMap) ? $resultMap["applTime"] : "null" ) ?>
                        </label>

						<?php

						if (isset($resultMap["payMethod"]) && strcmp("VBank", $resultMap["payMethod"]) == 0) { //가상계좌
                            echo "
							<label class='col-10 col-sm-2 input param' style='border:none;'>VACT_Num</label>
                            <label class='col-10 col-sm-9 reinput'>".@(in_array($resultMap["VACT_Num"] , $resultMap) ? $resultMap["VACT_Num"] : "null" ).
                            "</label>

							<label class='col-10 col-sm-2 input param' style='border:none;'>VACT_BankCode</label>
                            <label class='col-10 col-sm-9 reinput'>".@(in_array($resultMap["VACT_BankCode"] , $resultMap) ? $resultMap["VACT_BankCode"] : "null" ).
                            "</label>

							<label class='col-10 col-sm-2 input param' style='border:none;'>VACT_Date</label>
                            <label class='col-10 col-sm-9 reinput'>".@(in_array($resultMap["VACT_Date"] , $resultMap) ? $resultMap["VACT_Date"] : "null" ).
                            "</label>"
							;
                        } else if (isset($resultMap["payMethod"]) && strcmp("VCard", $resultMap["payMethod"]) == 0) { //신용카드(ISP)
                             echo "
						    <label class='col-10 col-sm-2 input param' style='border:none;'>applNum</label>
                            <label class='col-10 col-sm-9 reinput'>".@(in_array($resultMap["applNum"] , $resultMap) ? $resultMap["applNum"] : "null" ).
                            "</label>"
							;
						}else if (isset($resultMap["payMethod"]) && strcmp("Card", $resultMap["payMethod"]) == 0) { //신용카드(안심클릭)
							echo "
						    <label class='col-10 col-sm-2 input param' style='border:none;'>applNum</label>
                            <label class='col-10 col-sm-9 reinput'>".@(in_array($resultMap["applNum"] , $resultMap) ? $resultMap["applNum"] : "null" ).
                            "</label>"
							;
						}

						?>

                    </div>
                </form>

				<button onclick="location.href='INIstdpay_pc_req.php'" class="btn_solid_pri col-6 mx-auto btn_lg" style="margin-top:50px">돌아가기</button>

                </div>
            </section>

        </main>

    </body>
</html>
