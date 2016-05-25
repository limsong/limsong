$(document).ready(function () {
    //전체 아이템 체크 ~ 해제
    $('.chkAllitem').click(function () {
        var total = 0;
        var total_shipping = 0;
        var allcheck = this.checked;

        $('input[type="checkbox"]').prop("checked", this.checked);
        $('input[type="checkbox"]').each(function (i) {
            var data_price = $(this).attr("data-price");
            if (data_price != undefined) {
                total += parseInt(data_price);
                if (total_shipping == 0) {
                    total_shipping = parseInt($(this).parent().parent().find(".shipping").attr("data-shipping"));
                }
            }
        });
        if (allcheck) {
            $(".total-num").text(formatNumber(total));
            $(".ship-amount").text(formatNumber(total_shipping));
            $(".cart-totalNum").text(formatNumber(total + total_shipping));
        } else {
            $(".total-num").text(0);
            $(".ship-amount").text(0);
            $(".cart-totalNum").text(0);
        }
    });
    //개별체크
    $(".chkitem").click(function () {
        var total = 0;
        var total_shipping = 0;
        $(".chkitem").each(function (i) {
            var data_price = $(this).attr("data-price");
            if (this.checked) {
                if (data_price != undefined) {
                    total += parseInt(data_price);
                    total_shipping += parseInt($(this).parent().parent().find(".shipping").attr("data-shipping"));
                }
            }
        });
        if (total_shipping > 0) {
            total_shipping = 2500;
        } else {
            total_shipping = 0;
        }
        $(".total-num").text(formatNumber(total));
        $(".ship-amount").text(formatNumber(total_shipping));
        $(".cart-totalNum").text(formatNumber(total + total_shipping));
    });
    //아이템  추가
    $(".item-plus").on('click', function () {
        var url = "resultItem.php";
        var dataCode = $(this).attr("data-id");
        var form_data = {code: dataCode};
        $.ajax({
            type: "POST",
            url: url,
            /*dataType: "XML",*/
            data: form_data,
            error: function (response) {
                alert(response.responseText);
            },
            success: function (response) {
                $(".modal-body").html("");
                add_optionbox(response);
            }
        });
    });
    //아이템 빼기
    $(".item-minus").on('click', function () {
        var url = "resultItem.php";
        var dataCode = $(this).attr("data-id");
        var form_data = {code: dataCode};
        $.ajax({
            type: "POST",
            url: url,
            /*dataType: "XML",*/
            data: form_data,
            error: function (response) {
                alert(response.responseText);
            },
            success: function (response) {
                $(".modal-body").html("");
                add_optionbox(response);
            }
        });
    });

    //숫자 포맷
    function formatNumber(num, precision, separator) {
        var parts;
        if (!isNaN(parseFloat(num)) && isFinite(num)) {
            num = Number(num);
            num = (typeof precision !== 'undefined' ? num.toFixed(precision) : num).toString();
            parts = num.split('.');
            parts[0] = parts[0].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1' + (separator || ','));
            return parts.join('.');
        }
        return NaN;
    }

    // 추가옵션/수정
    $(".chgops").click(function () {
        var url = "resultItem.php";
        var dataCode = $(this).attr("data-id");
        var form_data = {code: dataCode};
        $.ajax({
            type: "POST",
            url: url,
            /*dataType: "XML",*/
            data: form_data,
            error: function (response) {
                alert(response.responseText);
            },
            success: function (response) {
                $(".modal-body").html("");
                add_optionbox(response);
            }
        });
    });
    function add_optionbox(htm) {
        $(".modal-body").append(htm);//추가옵션 div에 추가
        $(".btn-lg").trigger("click");//버튼 클릭//추가옵션  div 보기

        /* 추가옵션 토탈추가 시작 */
        //옵션 첸지
        $(".bsoption").on('change', function () {
            var selVal = $(this, 'option:selected').val();
            var mod = true;
            total_sum = $(".totalSum").attr("data");
            if (!selVal) {
                return false;
            }

            var data = $(this).find("option:selected").attr("data");
            var itemName = $(this).find("option:selected").text();
            $(".s-item").find("input[type=hidden]").each(function (i) {
                if ($(this).val() == data) {
                    alert("이미 추가된 상품 입니다.");
                    $(".bsoption").get(i).selectedIndex = 0;
                    mod = false;
                    return false;
                }
            });
            if (mod == false) {
                return false;
            }
            if (total == false) {
                $(".total").css("display", "block");
                total = true;
            }


            addOPItemArr.unshift(data);//unshift      데이터를 배열 첫번째에 넣어준다.
            opnumArr.unshift("1");//옵션 상품 구매개수
            total_num = addOPItemArr.length + addItemArr.length;
            total_sum = parseInt(selVal) + parseInt(total_sum);
            $(".totalSum").text(formatNumber(total_sum));
            $(".totalSum").attr("data", total_sum);
            $(".totalNum").text(total_num);
            var rHtm = '<div class="col-md-12" style="padding:0px;"><div class="col-md-12" style="margin:5px 0px;"></div>' +
                '<input type="hidden" name="optionid[]" value="' + data + '">' +
                '<div class="col-md-7 cm12" style="line-height:25px;height:25px;">' + itemName + '</div>' +
                '<div class="col-md-2 cm6"  style="padding:0px;">' +
                '<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;">' +
                '<i class="fa fa-minus item-minus"></i>' +
                '</div>' +
                '<div class="col-md-4 cm4" style="padding:0px;text-align:center;"><input type="text" name="opnum[]" class="item_num" value="1"></div>' +
                '<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;">' +
                '<i class="fa fa-plus item-plus"></i>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-3 cm6"  style="line-height:25px;height:25px;text-align:right;padding:0px;">' +
                '<span data="' + selVal + '" class="sub_pric">' + formatNumber(selVal) + '</span>' +
                '<span style="color:#e26a6a;">원</span>' +
                '<i data-toggle="tooltip" data-original-title="삭제" class="fa fa-trash-o"></i>' +
                '</div>' +
                '</div>';

            $(".s-item").append(rHtm);
        });
        $(".s-item").on('click', '.item-plus', function () {
            var id = $(this).parent().parent().parent().find("input:first").val();
            var sub_pric = $(this).parent().parent().parent().find(".sub_pric").attr("data");
            var total_sum = $(".totalSum").attr("data");
            var total_sum_tmp = parseInt(total_sum);
            var obj = $(this).parent().parent().find(".item_num");
            var str = obj.val();
            var sub_pric_tmp = parseInt(sub_pric);
            var str2 = 0;
            var str3 = 0;
            str = parseInt(str) + 1;
            obj.val(str);
            for (var i = 0; i < addOPItemArr.length; i++) {
                if (addOPItemArr[i] == id) {
                    opnumArr.splice(i, 1, str);
                }
            }
            sub_pric = parseInt(sub_pric);
            total_sum = parseInt(total_sum) + sub_pric_tmp;
            $(".totalSum").text(formatNumber(total_sum));
            $(".totalSum").attr("data", total_sum);
            $(".s-item").find(".item_num").each(function (i) {
                str2 = parseInt(str2) + parseInt($(this).val());
            });
            $(".m-item").find(".item_num").each(function (i) {
                str3 = parseInt(str3) + parseInt($(this).val());
            });
            $(".totalNum").text(parseInt(str2) + parseInt(str3));
            //$(this).parent().parent().parent().find(".sub_pric").text(formatNumber(sub_pric*str));
        });
        $(".s-item").on('click', '.item-minus', function () {
            var id = $(this).parent().parent().parent().find("input:first").val();
            var str = $(this).parent().parent().find(".item_num").val();
            var sub_pric = $(this).parent().parent().parent().find(".sub_pric").attr("data");
            var total_sum = $(".totalSum").attr("data");
            var sub_pric_tmp = parseInt(sub_pric);
            var str_tmp = parseInt(str);
            var str2 = 0;
            var str3 = 0;
            if (parseInt(str) > 1) {
                str = parseInt(str) - 1;
                $(this).parent().parent().find(".item_num").val(str);
                sub_pric = parseInt(sub_pric);
                total_sum = parseInt(total_sum) - sub_pric;
                $(".totalSum").text(formatNumber(total_sum));
                $(".totalSum").attr("data", total_sum);
                $(".s-item").find(".item_num").each(function (i) {
                    str2 = parseInt(str2) + parseInt($(this).val());
                });
                $(".m-item").find(".item_num").each(function (i) {
                    str3 = parseInt(str3) + parseInt($(this).val());
                });
                $(".totalNum").text(parseInt(str2) + parseInt(str3));
                //$(this).parent().parent().parent().find(".sub_pric").text(formatNumber(sub_pric_tmp*str_tmp-sub_pric));
                for (var i = 0; i < addOPItemArr.length; i++) {
                    if (addOPItemArr[i] == id) {
                        opnumArr.splice(i, 1, str);
                    }
                }
            } else {
                $(this).parent().parent().find(".item_num").val("1");
                for (var i = 0; i < addOPItemArr.length; i++) {
                    if (addOPItemArr[i] == id) {
                        opnumArr.splice(i, 1, "1");
                    }
                }
            }
        });
        $('.s-item').on('click', '.fa-trash-o', function (e) {
            var id = $(this).parent().parent().find("input:first").val();
            if (id == "no") {
                return false;
            }
            $(this).parent().parent().find("input:first").val("no");
            var total_sum = $(".totalSum").attr("data");
            var sub_pric = $(this).parent().parent().find(".sub_pric").attr("data");
            var sub_num = $(this).parent().parent().find(".item_num").val();
            $(this).parent().parent().remove();
            for (var i = 0; i < addOPItemArr.length; i++) {
                if (addOPItemArr[i] == id) {
                    addOPItemArr.splice(i, 1);
                    opnumArr.splice(i, 1);
                }
            }
            total_sum = parseInt(total_sum);
            //total_num = addItemArr.length + addOPItemArr.length;
            total_num = parseInt($(".totalNum").text()) - parseInt(sub_num);
            var total_fsum = total_sum - parseInt(sub_pric) * parseInt(sub_num);
            $(".totalSum").text(formatNumber(total_fsum));
            $(".totalSum").attr("data", total_fsum);
            $(".totalNum").text(total_num);
            if (total_num == 0) {
                $(".total").css("display", "none");
                total = false;
            }

        });
        /* 추가옵션 토탈추가  끝 */

        /* 메인상품 토탈추가 시작 */
        $("select[name=bsitem]").on("change", function () {
            var goods_opt_type = $(".goods_opt_type").val();
            var goods_code = $(".goods_code").val();
            var optNum = $(".optNum").val();
            if (goods_opt_type == "1") {
                //일반옵션
                var mod = $(this)[0].selectedIndex;
                var selVal = $(this, 'option:selected').val();
                if (mod != 0) {
                    var data1 = $(this).find("option:selected").attr("data");
                    var data2 = $(this).find("option:selected").attr("data1");
                    var data3 = $(this).find("option:selected").attr("data2");
                } else {
                    return false;
                }
            } else {
                //가격선택옵션
                var optNum = $(".optNum").val();
                var cls = $(this).attr("class");
                var mod = $(this)[0].selectedIndex;
                if (optNum == "2") {
                    //가격선택옵션2
                    if (mod != 0) {
                        if (cls == "bsitem1") {
                            var opVal = $(".bsitem2 option:eq(0)").text();
                            var opName = $(".bsitem1 option:selected").text();
                            var url = "item_viewPost.php";
                            var form_data = {
                                goods_code: goods_code,
                                optNum: optNum,
                                opname1: opName,
                                opVal: opVal
                            };
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: form_data,
                                error: function () {
                                    alert("상품 선택 실패하였습니다.관리자에게 문의해주세요.");
                                },
                                success: function (response) {
                                    $(".bsitem2").empty();
                                    $(".bsitem2").append(response);
                                }
                            });
                            return false;
                        } else {
                            var data = $(this).find("option:selected").attr("data");
                            var mod = $(this)[0].selectedIndex;
                            var selVal = $(this, 'option:selected').val();
                            if (mod != 0) {
                                var data1 = $(this).find("option:selected").attr("data");
                                var data2 = $(this).find("option:selected").attr("data1");
                                var data3 = $(this).find("option:selected").attr("data2");
                            }
                        }
                    } else {
                        var opVal = $(".bsitem2 option:eq(0)").text();
                        $(".bsitem2").empty();
                        var option = '<option>' + opVal + '</option>';
                        $(".bsitem2").append(option);
                        return false;
                    }
                } else {
                    //가격선택옵션3
                    var mod = $(this)[0].selectedIndex;
                    if (mod != 0) {
                        if (cls == "bsitem1") {
                            var i = 0;
                            var opVal = $(".bsitem2 option:eq(0)").text();
                            var opVal2 = $(".bsitem3 option:eq(0)").text();
                            var opName = $(".bsitem1 option:selected").text();
                            var url = "item_viewPost.php";
                            var form_data = {
                                goods_code: goods_code,
                                optNum: optNum,
                                opname1: opName,
                                opVal: opVal
                            };
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: form_data,
                                error: function () {
                                    alert("상품 선택 실패하였습니다.관리자에게 문의해주세요.");
                                },
                                success: function (response) {
                                    $(".bsitem2").empty();//2번 옵션 비움
                                    $(".bsitem3").empty();//3번옵션 비움
                                    $(".bsitem2").append(response);
                                    var option = '<option>' + opVal2 + '</option>';
                                    $(".bsitem3").append(option);//3번 옵션 초기화
                                }
                            });
                            return false;
                        } else if (cls == "bsitem2") {
                            var opVal = $(".bsitem3 option:eq(0)").text();
                            var opName = $(".bsitem1 option:selected").text();
                            var opName1 = $(".bsitem2 option:selected").text();
                            var url = "item_viewPost.php";
                            var form_data = {
                                goods_code: goods_code,
                                optNum: optNum,
                                opname1: opName,
                                opname2: opName1,
                                opVal: opVal
                            };
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: form_data,
                                error: function () {
                                    alert("상품 선택 실패하였습니다.관리자에게 문의해주세요.");
                                },
                                success: function (response) {
                                    $(".bsitem3").empty();
                                    $(".bsitem3").append(response);
                                }
                            });
                            return false;
                        } else {
                            var data = $(this).find("option:selected").attr("data");
                            var mod = $(this)[0].selectedIndex;
                            var selVal = $(this, 'option:selected').val();
                            if (mod != 0) {
                                var data1 = $(this).find("option:selected").attr("data");
                                var data2 = $(this).find("option:selected").attr("data1");
                                var data3 = $(this).find("option:selected").attr("data2");
                                var data4 = $(this).find("option:selected").attr("data3");
                            }
                        }
                    } else {
                        var opVal1 = $(".bsitem2 option:eq(0)").text();
                        var opVal2 = $(".bsitem3 option:eq(0)").text();
                        $(".bsitem2").empty();
                        $(".bsitem3").empty();
                        var option = '<option>' + opVal1 + '</option>';
                        $(".bsitem2").append(option);
                        var option = '<option>' + opVal2 + '</option>';
                        $(".bsitem3").append(option);//3번 옵션 초기화
                        return false;
                    }
                }
            }

            if (goods_opt_type == "1") {
                var cv = goods_code + "_" + data1 + "_" + data2;
            } else if (goods_opt_type = "2") {
                if (optNum == "2") {
                    var cv = goods_code + "_" + data1 + "_" + data2;
                } else {
                    var cv = goods_code + "_" + data1 + "_" + data2 + "_" + data3;
                }
            }
            total_sum = $(".totalSum").attr("data");
            if (!selVal) {
                return false;
            }
            if (total == false) {
                $(".total").css("display", "block");
                total = true;
            }
            if (data4 == undefined) {
                data4 = "";
            }
            var data = $(this).find("option:selected").attr("data");
            if (data4 == "") {
                var itemName = data2 + " - " + data3;
            } else {
                var itemName = data2 + " - " + data3 + "-" + data4;
            }

            for (var i = 0; i < addItemArr.length; i++) {
                if (addItemArr[i] == data) {
                    alert("이미 추가된 상품 입니다.");
                    return false;
                }
            }
            addItemArr.unshift(data);//unshift      데이터를 배열 첫번째에 넣어준다.
            itemnumArr.unshift("1");//메인상품 구매 개수
            total_sum = parseInt(selVal) + parseInt(total_sum);
            total_num = $(".totalNum").text();
            total_num = parseInt(total_num) + 1;
            $(".totalSum").text(formatNumber(total_sum));
            $(".totalSum").attr("data", total_sum);
            $(".totalNum").text(total_num);
            var rHtm = '<div class="col-md-12 cm12" style="padding:0px;"><div class="col-md-12" style="margin:5px 0px;"></div>' +
                '<input type="hidden" name="itemid[]" value="' + data + '" data="' + cv + '">' +
                '<div class="col-md-6 cm12">' + itemName + '</div>' +
                '<div class="col-md-3 cm6">' +
                '<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;"><i class="fa fa-minus item-minus"></i></div>' +
                '<div class="col-md-4 cm4" style="padding:0px;text-align:center;"><input type="text" name="itemnum[]" class="item_num" value="1"></div>' +
                '<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;"><i class="fa fa-plus item-plus"></i></div>' +
                '</div>' +
                '<div class="col-md-3 cm6"  style="text-align:right;padding:0px;">' +
                '<span data="' + selVal + '" class="sub_pric">' + formatNumber(selVal) + '</span>' +
                '<span style="color:#e26a6a;">원</span>' +
                '<i data-toggle="tooltip" data-original-title="삭제" class="fa fa-trash-o"></i>' +
                '</div>' +
                '</div>';
            $(".m-item").append(rHtm);

            $('.m-item').on('click', '.fa-trash-o', function (e) {
                var id = $(this).parent().parent().find("input:first").val();
                if (id == "no") {
                    return false;
                }
                $(this).parent().parent().find("input:first").val("no");
                for (var i = 0; i < addItemArr.length; i++) {
                    if (addItemArr[i] == id) {
                        addItemArr.splice(i, 1);
                        itemnumArr.splice(i, 1);
                    }
                }
                var total_sum = $(".totalSum").attr("data");
                var sub_pric = $(this).parent().parent().find(".sub_pric").attr("data");
                var sub_str = $(this).parent().parent().find(".item_num").val();
                total_sum = parseInt(total_sum);
                total_num = addItemArr.length + addOPItemArr.length;
                var total_fsum = total_sum - parseInt(sub_pric) * parseInt(sub_str);
                $(".totalSum").text(formatNumber(total_fsum));
                $(".totalSum").attr("data", total_fsum);
                $(".totalNum").text(total_num);
                if (total_num == 0) {
                    $(".total").css("display", "none");
                    total = false;
                }
                $(this).parent().parent().remove();
            });
        });
        $(".m-item").on('click', '.item-plus', function () {
            var id = $(this).parent().parent().parent().find("input:first").val();
            var sub_pric = $(this).parent().parent().parent().find(".sub_pric").attr("data");
            var total_sum = $(".totalSum").attr("data");
            var obj = $(this).parent().parent().find(".item_num");
            var str = obj.val();
            var sub_pric_tmp = parseInt(sub_pric);
            var str2 = 0;
            var str3 = 0;
            str = parseInt(str) + 1;
            obj.val(str);
            $(".s-item").find(".item_num").each(function (i) {
                str2 = parseInt(str2) + parseInt($(this).val());
            });
            $(".m-item").find(".item_num").each(function (i) {
                str3 = parseInt(str3) + parseInt($(this).val());
            });
            $(".totalNum").text(parseInt(str2) + parseInt(str3));
            for (var i = 0; i < addItemArr.length; i++) {
                if (addItemArr[i] == id) {
                    itemnumArr.splice(i, 1, str);
                }
            }
            sub_pric = parseInt(sub_pric);
            total_sum = parseInt(total_sum) + sub_pric_tmp;
            $(".totalSum").text(formatNumber(total_sum));
            $(".totalSum").attr("data", total_sum);
            //$(this).parent().parent().parent().find(".sub_pric").text(formatNumber(sub_pric*str));
        });
        $(".m-item").on('click', '.item-minus', function () {
            var id = $(this).parent().parent().parent().find("input:first").val();
            var str = $(this).parent().parent().find(".item_num").val();
            var sub_pric = $(this).parent().parent().parent().find(".sub_pric").attr("data");
            var total_sum = $(".totalSum").attr("data");
            var sub_pric_tmp = parseInt(sub_pric);
            var str_tmp = parseInt(str);
            var str2 = 0;
            var str3 = 0;
            if (parseInt(str) > 1) {
                str = parseInt(str) - 1;
                $(this).parent().parent().find(".item_num").val(str);
                sub_pric = parseInt(sub_pric);
                total_sum = parseInt(total_sum) - sub_pric;
                $(".totalSum").text(formatNumber(total_sum));
                $(".totalSum").attr("data", total_sum);
                $(".s-item").find(".item_num").each(function (i) {
                    str2 = parseInt(str2) + parseInt($(this).val());
                });
                $(".m-item").find(".item_num").each(function (i) {
                    str3 = parseInt(str3) + parseInt($(this).val());
                });

                $(".totalNum").text(parseInt(str2) + parseInt(str3));
                //$(this).parent().parent().parent().find(".sub_pric").text(formatNumber(sub_pric_tmp*str_tmp-sub_pric));
                for (var i = 0; i < addItemArr.length; i++) {
                    if (addItemArr[i] == id) {
                        itemnumArr.splice(i, 1, str);
                    }
                }
            } else {
                $(this).parent().parent().find(".item_num").val("1");
                for (var i = 0; i < addItemArr.length; i++) {
                    if (addItemArr[i] == id) {
                        itemnumArr.splice(i, 1, "1");
                    }
                }
            }
        });
        $('.m-item').on('click', '.fa-trash-o', function (e) {
            var inpData = $(this).parent().parent().find("input:first").attr("data");
            var idlen = $(".m-item").find("input[type=hidden]").length;
            if (idlen == 1) {
                alert("옵션은 반드시 1개 이상 설정하셔야 합니다.");
                return false;
            }
            if (inpData == "no") {
                return false;
            }
            $(this).parent().parent().find("input:first").attr("data", "no");
            for (var i = 0; i < addItemArr.length; i++) {
                if (addItemArr[i] == id) {
                    addItemArr.splice(i, 1);
                    itemnumArr.splice(i, 1);
                }
            }
            var total_sum = $(".totalSum").attr("data");
            var sub_pric = $(this).parent().parent().find(".sub_pric").attr("data");
            var sub_num = $(this).parent().parent().find(".item_num").val();
            total_sum = parseInt(total_sum);
            total_num = parseInt($(".totalNum").text()) - parseInt(sub_num);
            var total_fsum = total_sum - parseInt(sub_pric) * parseInt(sub_num);
            $(".totalSum").text(formatNumber(total_fsum));
            $(".totalSum").attr("data", total_fsum);
            $(".totalNum").text(total_num);
            if (total_num == 0) {
                $(".total").css("display", "none");
                total = false;
            }
            $(this).parent().parent().remove();
        });
        /* 메인상품 토탈추가 끝 */
    }

    $(".submit").click(function () {
        $(".itemchgform").submit();
    });
    $(".delitem").click(function () {
        var code = $(this).attr("data");
        var url = "delcartitem.php";
        var form_data = {
            code: code
        };
        $.ajax({
            type: "POST",
            url: url,
            data: form_data,
            error: function (response) {
                alert('삭제 실패하였습니다.관리자에게 문의해 주세요');
            },
            success: function (response) {
                location.href = "shopping_cart.php";
            }
        });
    });
    $(".sub-go").click(function () {
        var len = 0;
        $("input[type='checkbox'][class='chkitem']").each(function (i) {
            if (this.checked) {
                len++;
                $(".cart_form").submit();
            }
        });
        if (len == 0) {
            alert("구매하실 상품을 선택해주세요.");
            return false;
        }
    });
});