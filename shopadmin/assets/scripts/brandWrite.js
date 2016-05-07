/**
 * Created by limsong on 2016. 3. 16..
 */
$(document).ready(function () {
      loadingMask('on');
      displaySortList('00', '00', '0');
      function loadingMask(mode) {
            if (mode == 'on') {
                  document.getElementById("loading-mask").style.display = 'block';
                  document.getElementById("loading").style.display = 'block';
            } else if (mode == 'off') {
                  document.getElementById("loading-mask").style.display = 'none';
                  document.getElementById("loading").style.display = 'none';
            }
      }

      $(".fileClear").click(function () {
            var file = $(this).prev();
            file.after(file.clone().val(""));
            file.remove();
      });
      // Add new input with associated 'remove' link when 'add' button is clicked.
      $('.addthumImage').click(function (e) {
            e.preventDefault();
            var cls = $(this).attr("data");
            $("." + cls).append(
                  '<dt style="background-color:white;"></dt>'
                  + '<dd class=\"inputDd\">'
                  + '<img src="images/i_del.gif" class="remove_project_file" data="dlt" />'
                  + '<input type=\"file\" name=\"thumImage[]\" class=\"inputItem fileHeight\" />'
                  + '</dd>');
      });
      // Remove parent of 'remove' link when link is clicked.
      $('.dltimg').on('click', '.remove_project_file', function (e) {
            e.preventDefault();
            $(this).parent().prev().remove();
            $(this).parent().remove();
      });

      $('.addsmImage').click(function (e) {
            e.preventDefault();
            var cls = $(this).attr("data");
            $("." + cls).append(
                  '<dt style="background-color:white;"></dt>'
                  + '<dd class="inputDd">'
                  + '<img src="images/i_del.gif" class="remove_project_file" data="dlt" />'
                  + '<input type="file" name="smImage[]" class="inputItem fileHeight" />'
                  + '</dd>');
      });
      // Remove parent of 'remove' link when link is clicked.
      $('.dlsimg').on('click', '.remove_project_file', function (e) {
            e.preventDefault();
            $(this).parent().prev().remove();
            $(this).parent().remove();
      });

      $('.addmdImage').click(function (e) {
            e.preventDefault();
            var cls = $(this).attr("data");
            $("." + cls).append(
                  '<dt style="background-color:white;"></dt>'
                  + '<dd class=\"inputDd\">'
                  + '<img src="images/i_del.gif" class="remove_project_file" data="dlt" />'
                  + '<input type=\"file\" name=\"mdImage[]\" class=\"inputItem fileHeight\" />'
                  + '</dd>');
      });
      $('.dlmimg').on('click', '.remove_project_file', function (e) {
            e.preventDefault();
            $(this).parent().prev().remove();
            $(this).parent().remove();
      });
      $('.addbigImage').click(function (e) {
            e.preventDefault();
            var cls = $(this).attr("data");
            $("." + cls).append(
                  '<dt style="background-color:white;"></dt>'
                  + '<dd class=\"inputDd\">'
                  + '<img src="images/i_del.gif" class="remove_project_file" data="dlt" />'
                  + '<input type=\"file\" name=\"bigImage[]\" class=\"inputItem fileHeight\" />'
                  + '</dd>');
      });
      $('.dlbimg').on('click', '.remove_project_file', function (e) {
            e.preventDefault();
            $(this).parent().prev().remove();
            $(this).parent().remove();
      });
      //option_type 일반옵션 가격선택옵션.
      var strVal;
      var people;
      $("input[name=option_type]").click(function () {
            strVal = $(this).val();
            $("#qtBoxa").empty();
            if (strVal == "1" || strVal == "2") {
                  $(".DateBoxa").css("display", "inline");
                  $(".option_name").css("display", "inline");
                  $(".goods_option_inp").each(function () {
                        $(this).attr("readonly", true);
                        $(this).css("background-color", "#eee");
                  });
            } else {
                  $(".DateBoxa").css("display", "none");
                  $(".option_name").css("display", "none");
                  $(".goods_option_inp").each(function () {
                        $(this).attr("readonly", false);
                        $(this).css("background-color", "#fff");
                  });
                  $("#opName1").val("");
                  $("#opName2").val("");
                  $("#commonPrice").val("");
                  $("#sellPrice").val("");
                  $("#qta").val("");
            }
      });

      var c = 0;
      var cc = 0;
      $(".DateBoxa").click(function () {
            qtbox("a");
            var Fnum = $(".optNum").val();
            goods_opt_grid(Fnum);
      });
      $(".DateBox").click(function () {
            qtbox("b");
      });
      function qtbox(mod) {
            var moda = false;
            if (mod == "a") {
                  var str = "a";
                  var opName1 = $("#opName1").val();
                  var opName2 = $("#opName2").val();
                  var commonPrice = $("#commonPrice").val();
                  var sellPrice = $("#sellPrice").val();
                  var qta = $("#qta").val();
            } else if (mod == "b") {
                  var str = "";
                  var opName1 = $("#opName3").val();
                  var opName2 = $("#opName4").val();
                  var commonPrice = $("#opValue1").val();
                  var sellPrice = $("#opValue2").val();
                  var qta = $("#qt").val();
            }

            if (opName1 == "") {
                  if (mod == "a") {
                        cc = 0;
                  } else {
                        c = 0;
                  }
                  create_box(str);
            } else {
                  //데이터 읽어들이기
                  create_box(str);
                  var opName1Arr = new Array();
                  var opName2Arr = new Array();
                  var commonPriceArr = new Array();
                  var sellPriceArr = new Array();
                  var qtaArr = new Array();

                  var opName2Arr2 = new Array();
                  var commonPriceArr2 = new Array();
                  var sellPriceArr2 = new Array();
                  var qtaArr2 = new Array();

                  opName1Arr = opName1.split("/");
                  opName2Arr = opName2.split("/");
                  commonPriceArr = commonPrice.split("/");
                  sellPriceArr = sellPrice.split("/");
                  qtaArr = qta.split("/");
                  var itemLen = opName1Arr.length;
                  var ins_htm = "";
                  cc = 0;
                  c = 0;
                  if (mod == "a") {
                        var num = cc;
                  } else {
                        var num = c;
                  }
                  if(mod == "a" && strVal == "2"){

                  }else{
                        for (var i = 0; i < itemLen; i++) {
                              opName2Arr2 = opName2Arr[i].split(";");
                              commonPriceArr2 = commonPriceArr[i].split(";");
                              sellPriceArr2 = sellPriceArr[i].split(";");
                              qtaArr2 = qtaArr[i].split(";");
                              var itemLen2 = qtaArr2.length;

                              for (var j = 0; j < itemLen2; j++) {
                                    if (j == 0) {
                                          ins_htm += '<tr style="background-color:#3a5795" class="op_box' + str + num + '">' +
                                                '<td>' + (i + 1) + '</td>' +
                                                '<td><input class="border opName1' + str + i + '" style="width:99%;background-color:#3a5795;color:white;" value="' + opName1Arr[i] + '"></td>' +
                                                '<td><input class="border opName2' + str + i + '" style="width:99%;background-color:#3a5795;color:white;" value="' + opName2Arr2[j] + '"></td>' +
                                                '<td><input class="border opValue1' + str + i + '" style="width:97%;background-color:#3a5795;color:white;" value="' + commonPriceArr2[j] + '"></td>' +
                                                '<td><input class="border opValue2' + str + i + '" style="width:97%;background-color:#3a5795;color:white;" value="' + sellPriceArr2[j] + '"></td>' +
                                                '<td><input class="border opN' + str + i + '" style="width:97%;background-color:#3a5795;color:white;" value="' + qtaArr2[j] + '"></td>' +
                                                '<td><span class="del_single_op" data="all"> 삭제 </span></td>' +
                                                '</tr>';
                                    } else {
                                          ins_htm += '<tr style="background-color:#3a5795" class="op_box' + str + num + '">' +
                                                '<td colspan="2" style="background-color:#4A74BC;"></td>' +
                                                '<td><input class="border opName2' + str + i + '" style="width:99%;background-color:#3a5795;color:white;" value="' + opName2Arr2[j] + '"></td>' +
                                                '<td><input class="border opValue1' + str + i + '" style="width:97%;background-color:#3a5795;color:white;" value="' + commonPriceArr2[j] + '"></td>' +
                                                '<td><input class="border opValue2' + str + i + '" style="width:97%;background-color:#3a5795;color:white;" value="' + sellPriceArr2[j] + '"></td>' +
                                                '<td><input class="border opN' + str + i + '" style="width:97%;background-color:#3a5795;color:white;" value="' + qtaArr2[j] + '"></td>' +
                                                '<td><span class="del_single_op" data="one"> 삭제 </span></td>' +
                                                '</tr>';
                                    }
                              }

                              ins_htm += '<tr style="background-color:#3a5795" class="op_box' + str + num + '">' +
                                    '<td colspan="7"><span class="option add_option' + str + num + '" data="op_box' + str + num + '"> + 옵션추가</span></td></tr>';
                              $("#DateBox" + str + "_add thead").append(ins_htm).find("span.add_option" + str + num).bind("click", function () {
                                    var strData = $(this).attr("data");
                                    var num = strData.split("op_box" + str);
                                    var ins_htm = '<tr style="background-color:#3a5795">' +
                                          '<td colspan="2" style="background-color:#4A74BC;"></td>' +
                                          '<td><input class="border opName2' + str + num[1] + '" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                                          '<td><input class="border opValue1' + str + num[1] + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                                          '<td><input class="border opValue2' + str + num[1] + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                                          '<td><input class="border opN' + str + num[1] + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                                          '<td><span class="del_single_op"> 삭제 </span></td>' +
                                          '</tr>';
                                    $(this).parent().parent().before(ins_htm);
                                    $(".del_single_op").click(function () {
                                          $(this).parent().parent().remove();
                                    });
                              });
                              $(".del_single_op").click(function () {
                                    if (moda == false) {
                                          var mod = $(this).attr("data");
                                          if (mod == "all") {
                                                var del_box = $(this).parent().parent().attr("class");
                                                $("." + del_box).remove();
                                                return false;
                                          } else {
                                                $(this).parent().parent().remove();
                                          }
                                            if(mod == "a"){
                                                    $(".transQna").trigger("click");
                                                    $(".DateBoxa").trigger("click");
                                            }else{
                                                    $(".transQn").trigger("click");
                                                    $(".DateBox").trigger("click");
                                            }

                                          moda = true;
                                    }
                              });
                              ins_htm = "";
                              if (mod == "a") {
                                    cc++;
                              } else {
                                    c++;
                              }
                              num++;
                        }
                  }
            }
      }

      function create_box(str) {
            var resHtml = "";
            //메인 top 옵션 열추가
            //head
            if (str == "a" && strVal == "2") {
                  resHtml += '<div style="width:100%;float:left;background-color:#3a5795"><span style="float:right;color:white;line-height: 35px;;padding:0px 10px;">옵션갯수 : <select class="optNum"><option>옵션갯수선택</option><option value="2">2</option><option value="3">3</option></select></span><span class="add_box' + str + '" style="width:170px;vertical-align: middle;padding: 7px 0px;background-color:#4A74BC;cursor: pointer;color:white;font-size:12px;float:right;text-align:center;display: none;;"> + 열추가</span></div>';
                  resHtml += '<div style="width:970px;">';
                  resHtml += '<table width="100%" border="0" cellspacing="1" cellpadding="3" style="background-color:#4A74BC;text-align:center;box-shadow: 10px 10px 5px #888;color:white;" id="DateBox' + str + '_add">';
                  resHtml += '<thead><tr style="background-color:#bfc4dd;font-weight:bold;font-size:12px;color:#333;">' +
                        '<td width="26">#</td>' +
                        '<td width="405" height="25">옵션명1</td>' +
                        '<td width="435" height="25">옵션명2</td>' +
                        '<td width="60">삭제</td>' +
                        '</tr></thead>';
                  resHtml += '</table></div>' +
                        '<div style="width:100%;float:left;background-color:#3a5795;">' +
                        '<input type="button" value="확인" style="margin-left:400px;" class="memEleB grid_box" />' +
                        ' <input type="button" value="닫기" class="memEleB closeQn' + str + '" />' +
                        '</div>';
            } else {
                  resHtml += '<div style="width:100%;float:left;background-color:#3a5795"><span class="add_box' + str + '" style="width:170px;vertical-align: middle;padding: 7px 0px;background-color:#4A74BC;cursor: pointer;color:white;font-size:12px;float:right;text-align:center;"> + 열추가</span></div>';
                  resHtml += '<div style="width:970px;">';
                  resHtml += '<table width="100%" border="0" cellspacing="1" cellpadding="3" style="background-color:#4A74BC;text-align:center;box-shadow: 10px 10px 5px #888;color:white;" id="DateBox' + str + '_add">';
                  resHtml += '<thead><tr style="background-color:#bfc4dd;font-weight:bold;font-size:12px;color:#333;">' +
                        '<td width="26">#</td>' +
                        '<td width="195" height="25">옵션명1</td>' +
                        '<td width="195" height="25">옵션명2</td>' +
                        '<td width="170">시장가/정찰가</td>' +
                        '<td width="170">판매가</td>' +
                        '<td width="70">재고</td>' +
                        '<td width="80">삭제</td>' +
                        '</tr></thead>';
                  resHtml += '</table></div>' +
                        '<div style="width:100%;float:left;background-color:#3a5795;text-align: center;">' +
                        '<input type="button" value="확인" style="margin-left:400px;" class="memEleB transQn' + str + '" />' +
                        ' <input type="button" value="닫기" class="memEleB closeQn' + str + '" />' +
                        '</div>';
            }
            var pObj = $("#qtBox" + str);
            pObj.html(resHtml);
            pObj.css("display", "inline");
            //닫기
            $(".closeQn" + str).click(function () {
                  $("#qtBox" + str).css("display", "none");
            });
            //확인
            $(".transQn" + str).click(function () {
                  var opName1 = "";
                  var opName2 = "";
                  var commonPrice = "";
                  var sellPrice = "";
                  var sellPriceTmp = "";
                  var qta = "";
                  if ($("#DateBoxa_add tr").length == 1) {
                        $("#opName1").val("");
                        $("#opName2").val("");
                        $("#commonPrice").val("");
                        $("#sellPrice").val("");
                        $("#qta").val("");
                  }
                  if ($("#DateBox_add tr").length == 1) {
                        $("#opName3").val("");
                        $("#opName4").val("");
                        $("#opValue1").val("");
                        $("#opValue2").val("");
                        $("#qt").val("");
                  }
                  if (str == "a") {
                        var num = cc;
                  } else {
                        var num = c;
                  }
                  var mod = false;
                  for (var i = 0; i < num; i++) {
                        var opName1Tmp = "";
                        var opName2Tmp = "";
                        var commonPriceTmp = "";
                        var qtaTmp = "";
                        var k = 0;
                        $("#DateBox" + str + "_add").find(".opName1" + str + i).each(function () {
                              if ($(this).val().trim() != "") {
                                    if (k == 0) {
                                          opName1Tmp = $(this).val();
                                    } else {
                                          opName1Tmp += ";" + $(this).val();
                                    }
                                    k++;
                              } else {
                                    mod = true;
                                    $(this).focus();
                                    return false;
                              }
                        });
                        k = 0;
                        $("#DateBox" + str + "_add").find(".opName2" + str + i).each(function () {
                              if ($(this).val().trim() != "") {
                                    if (k == 0) {
                                          opName2Tmp = $(this).val();
                                    } else {
                                          opName2Tmp += ";" + $(this).val();
                                    }
                                    k++;
                              } else {
                                    mod = true;
                                    $(this).focus();
                                    return false;
                              }
                        });
                        k = 0;
                        $("#DateBox" + str + "_add").find(".opValue1" + str + i).each(function () {
                              if ($(this).val().trim() != "") {
                                    if (k == 0) {
                                          commonPriceTmp = $(this).val();
                                    } else {
                                          commonPriceTmp += ";" + $(this).val();
                                    }
                                    k++;
                              } else {
                                    mod = true;
                                    $(this).focus();
                                    return false;
                              }
                        });
                        k = 0;
                        $("#DateBox" + str + "_add").find(".opValue2" + str + i).each(function () {
                              if ($(this).val().trim() != "") {
                                    if (k == 0) {
                                          sellPriceTmp = $(this).val();
                                    } else {
                                          sellPriceTmp += ";" + $(this).val();
                                    }
                                    k++;
                              } else {
                                    mod = true;
                                    $(this).focus();
                                    return false;
                              }
                        });

                        k = 0;
                        $("#DateBox" + str + "_add").find(".opN" + str + i).each(function () {
                              if ($(this).val().trim() != "") {
                                    if (k == 0) {
                                          qtaTmp = $(this).val();
                                    } else {
                                          qtaTmp += ";" + $(this).val();
                                    }
                                    k++;
                              } else {
                                    mod = true;
                                    $(this).focus();
                                    return false;
                              }
                        });
                        if (mod == true) {
                              alert("빈상품란을 입력해주세요.");
                              break;
                        }
                        if (opName1Tmp.trim() != "") {
                              if (opName1 == "") {
                                    opName1 = opName1Tmp;//옵션명1
                                    opName2 = opName2Tmp;
                                    commonPrice = commonPriceTmp;
                                    sellPrice = sellPriceTmp;
                                    qta = qtaTmp;
                              } else {
                                    opName1 += "/" + opName1Tmp;//옵션명1
                                    opName2 += "/" + opName2Tmp;
                                    commonPrice += "/" + commonPriceTmp;
                                    sellPrice += "/" + sellPriceTmp;
                                    qta += "/" + qtaTmp;
                              }
                        }

                  }
                  if (opName1 != "") {
                        if (str == "a") {
                              $("#opName1").val(opName1);//옵션명1
                              $("#opName2").val(opName2);//옵션명2
                              $("#commonPrice").val(commonPrice);//시정가/정찰가
                              $("#sellPrice").val(sellPrice);//판매가
                              $("#qta").val(qta);//재고
                        } else {
                              $("#opName3").val(opName1);//옵션명1
                              $("#opName4").val(opName2);//옵션명2
                              $("#opValue1").val(commonPrice);//시정가/정찰가
                              $("#opValue2").val(sellPrice);//판매가
                              $("#qt").val(qta);//재고
                        }
                  }
                  if (mod == false) {
                        $("#qtBox" + str).css("display", "none");
                  }
            });
            $(".optNum").change(function () {
                  var val = $(this).val();
                  $("input[name=optNum]").val(val);
                  $(".optNum").attr("disabled", "disabled");
                  for (var i = 0; i < val; i++) {
                        $(".add_box" + str).trigger("click");
                  }
            });

            var i = 0;
            $(".add_box" + str).click(function () {
                  if (str == "a") {
                        var num = cc;
                  } else {
                        var num = c;
                  }

                  var ins_htm = '<tr style="background-color:#3a5795" class="op_box' + str + num + '">';
                  if (str == "a" && strVal == "2") {
                        ins_htm += '<td>' + (num + 1) + '</td>' +
                              '<td><input class="border opName1' + str + num + '" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                              '<td><input class="border opName2' + str + num + '" style="width:99%;background-color:#3a5795;color:white;"></td>'
                        '</tr>';
                        ins_htm += '<tr style="background-color:#3a5795" class="op_box' + str + num + '">' +
                              '<td colspan="4"><span class="option add_option' + str + num + '" data="op_box' + str + num + '"> + 옵션추가</span></td></tr>';
                  } else {
                        ins_htm += '<td>' + (num + 1) + '</td>' +
                              '<td><input class="border opName1' + str + num + '" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                              '<td><input class="border opName2' + str + num + '" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                              '<td><input class="border opValue1' + str + num + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                              '<td><input class="border opValue2' + str + num + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                              '<td><input class="border opN' + str + num + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                              '<td><span class="del_single_op" data="op_box' + str + num + '"> 삭제 </span></td>' +
                              '</tr>';
                        ins_htm += '<tr style="background-color:#3a5795" class="op_box' + str + num + '">' +
                              '<td colspan="7"><span class="option add_option' + str + num + '" data="op_box' + str + num + '"> + 옵션추가</span></td></tr>';
                  }
                  $("#DateBox" + str + "_add thead").append(ins_htm).find("span.add_option" + str + num).bind("click", function () {
                        var strData = $(this).attr("data");
                        var num = strData.split("op_box" + str);
                        var data_num = $("." + $(this).attr("data")).length - 1;
                        var ins_htm = '<tr style="background-color:#3a5795" class="' + $(this).attr("data") + '">';
                        if (str == "a" && strVal == "2") {
                              ins_htm += '<td colspan="2" style="background-color:#4A74BC;"></td>' +
                                    '<td><input class="border opName2' + str + num[1] + '" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                                    '<td><span class="del_op" data-row="' + num[1] + '" data-num="' + data_num + '"> 삭제 </span></td>' +
                                    '</tr>';
                              $(".grid_div_box").empty();
                        } else {
                              ins_htm += '<td colspan="2" style="background-color:#4A74BC;"></td>' +
                                    '<td><input class="border opName2' + str + num[1] + '" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                                    '<td><input class="border opValue1' + str + num[1] + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                                    '<td><input class="border opValue2' + str + num[1] + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                                    '<td><input class="border opN' + str + num[1] + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                                    '<td><span class="del_op"> 삭제 </span></td>' +
                                    '</tr>';
                        }
                        $(this).parent().parent().before(ins_htm);
                        $(".del_op").on("click",function(){
                              $(this).parent().parent().remove();
                        });
                  });
                  if (str == "a") {
                        cc++;
                  } else {
                        c++;
                  }
                  $(".del_single_op").click(function () {
                        var del_box = $(this).attr("data");
                        $("." + del_box).remove();
                  });
            });

            $(".grid_box").click(function () {
                  var mod = false;
                  var Fnum = $(".optNum").val();
                  if (Fnum == 2) {
                        if ($(".opName1a0").val().trim() == "" || $(".opName1a1").val().trim() == "") {
                              if ($(".opName1a0").val().trim() == "") {
                                    $(".opName1a0").focus();
                              } else {
                                    $(".opName1a1").focus();
                              }
                              alert("빈 내용을 전부 입력해 주세요.");
                              return false;
                        }
                        var Len1 = $(".opName2a0").length;
                        var Len2 = $(".opName2a1").length;
                        var opName1Arr = new Array();
                        var opName2Arr = new Array();
                        var k = 0;
                        $(".opName2a0").each(function () {
                              if ($(this).val().trim() == "") {
                                    mod = true;
                                    $(this).focus();
                              }
                              opName1Arr[k] = $(this).val();
                              k++;
                        });
                        if (mod == true) {
                              alert("빈 내용을 전부 입력해 주세요.");
                              return false;
                        }
                        k = 0;
                        $(".opName2a1").each(function () {
                              if ($(this).val().trim() == "") {
                                    mod = true;
                                    $(this).focus();
                              }
                              opName2Arr[k] = $(this).val();
                              k++;
                        });
                        if (mod == true) {
                              alert("빈 내용을 전부 입력해 주세요.");
                              return false;
                        }
                        $(".grid_div_box").remove();
                        k = 1;
                        var tr_html = "";

                        for (var i = 0; i < Len1; i++) {
                              for (var j = 0; j < Len2; j++) {
                                    tr_html += '<tr style="background-color:#3a5795">';
                                    tr_html += '<td>' + k + '</td>';
                                    if (j == 0) {
                                          tr_html += '<td rowspan="' + Len2 + '">' + opName1Arr[i] + '</td>';
                                    }
                                    tr_html += '<td>' + opName2Arr[j] + '</td>';
                                    tr_html += '<td><input class="border op_commonPrice op_commonPrice' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>' +
                                          '<td><input class="border op_sellPrice op_sellPrice' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>' +
                                          '<td><input class="border op_qta op_qta' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>';
                                    k++;
                                    tr_html += '</tr>';
                              }

                        }
                        tr_html += '<tr style="background-color:#3a5795">' +
                              '<td colspan="3">' +
                              '<span class="op_ok"  style="width:100%;vertical-align: middle;padding: 3px 0px;background-color:#4A74BC;cursor: pointer;color:white;font-size:12px;float:left;"> 확인 </span>' +
                              '</td>' +
                              '<td colspan="3">' +
                              '<span class="op_cancel"  style="width:100%;vertical-align: middle;padding: 3px 0px;background-color:#4A74BC;cursor: pointer;color:white;font-size:12px;float:left;"> 취소 </span>' +
                              '</td>' +
                              '</tr>';
                  } else {
                        if ($(".opName1a0").val().trim() == "" || $(".opName1a1").val().trim() == "" || $(".opName1a2").val().trim() == "") {
                              if ($(".opName1a0").val() == "") {
                                    $(".opName1a0").focus();
                              } else if ($(".opName1a1").val() == "") {
                                    $(".opName1a1").focus();
                              } else {
                                    $(".opName1a2").focus();
                              }
                              alert("빈 내용을 전부 입력해 주세요.");
                              return false;
                        }
                        var Len1 = $(".opName2a0").length;
                        var Len2 = $(".opName2a1").length;
                        var Len3 = $(".opName2a2").length;
                        var opName1Arr = new Array();
                        var opName2Arr = new Array();
                        var opName3Arr = new Array();
                        var k = 0;
                        $(".opName2a0").each(function () {
                              if ($(this).val().trim() == "") {
                                    $(this).focus();
                                    mod = true;
                              } else {
                                    opName1Arr[k] = $(this).val();
                                    k++;
                              }
                        });
                        if (mod == true) {
                              alert("빈 내용을 전부 입력해 주세요.");
                              return false;
                        }
                        k = 0;
                        $(".opName2a1").each(function () {
                              if ($(this).val().trim() == "") {
                                    $(this).focus();
                                    mod = true;
                                    return false;
                              } else {
                                    opName2Arr[k] = $(this).val();
                                    k++;
                              }
                        });
                        if (mod == true) {
                              alert("빈 내용을 전부 입력해 주세요.");
                              return false;
                        }
                        k = 0;
                        $(".opName2a2").each(function () {
                              if ($(this).val().trim() == "") {
                                    $(this).focus();
                                    mod = true;
                                    return false;
                              } else {
                                    opName3Arr[k] = $(this).val();
                                    k++;
                              }
                        });
                        if (mod == true) {
                              alert("빈 내용을 전부 입력해 주세요.");
                              return false;
                        }
                        $(".grid_div_box").remove();
                        k = 1;
                        var tr_html = "";

                        for (var i = 0; i < Len1; i++) {
                              for (var j = 0; j < Len2; j++) {
                                    for (var n = 0; n < Len3; n++) {
                                          tr_html += '<tr style="background-color:#3a5795">';
                                          tr_html += '<td>' + k + '</td>';
                                          if (j == 0 && n == 0) {
                                                tr_html += '<td rowspan="' + Len2 * Len3 + '">' + opName1Arr[i] + '</td>';
                                          }
                                          if (n == 0) {
                                                tr_html += '<td rowspan="' + Len3 + '">' + opName2Arr[j] + '</td>';
                                          }
                                          tr_html += '<td>' + opName3Arr[n] + '</td>';

                                          if(people != undefined){
                                                  var TrHtml = json_each("3",opName1Arr[i],opName2Arr[j],opName3Arr[n],k);
                                                  if(TrHtml == ""){
                                                          tr_html += '<td><input class="border op_commonPrice op_commonPrice' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>' +
                                                                  '<td><input class="border op_sellPrice op_sellPrice' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>' +
                                                                  '<td><input class="border op_qta op_qta' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>';
                                                  }else{
                                                          tr_html += TrHtml;
                                                  }
                                          }else{
                                                tr_html += '<td><input class="border op_commonPrice op_commonPrice' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>' +
                                                      '<td><input class="border op_sellPrice op_sellPrice' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>' +
                                                      '<td><input class="border op_qta op_qta' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>';
                                          }
                                          k++;
                                          tr_html += '</tr>';
                                    }
                              }
                        }
                        tr_html += '<tr style="background-color:#3a5795">' +
                              '<td colspan="4">' +
                              '<span class="op_ok"  style="width:100%;vertical-align: middle;padding: 3px 0px;background-color:#4A74BC;cursor: pointer;color:white;font-size:12px;float:left;"> 확인 </span>' +
                              '</td>' +
                              '<td colspan="3">' +
                              '<span class="op_cancel"  style="width:100%;vertical-align: middle;padding: 3px 0px;background-color:#4A74BC;cursor: pointer;color:white;font-size:12px;float:left;"> 취소 </span>' +
                              '</td>' +
                              '</tr>';
                  }
                  var in_html = '<div style="width:100%;float:left;background-color:#3a5795;" class="grid_div_box">';
                  in_html += '<table border="0" cellspacing="1" cellpadding="3" style="width:100%;background-color:#4A74BC;text-align:center;box-shadow: 10px 10px 5px #888;color:white;">' +
                        '<tr>' +
                        '<td>시장가/정찰가</td>' +
                        '<td><input type="text" class="border commonPriceAll" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                        '<td>판매가</td>' +
                        '<td><input type="text" class="border sellPriceAll" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                        '<td>재고</td>' +
                        '<td><input type="text" class="border qtaAll" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                        '<td><span class="option AllPrice_check">일괄입력 </span></td>' +
                        '</tr>' +
                        '</table>';
                  in_html += '<table border="0" cellspacing="1" cellpadding="3" style="background-color:#4A74BC;text-align:center;box-shadow: 10px 10px 5px #888;color:white;" id="DateBoxb_add">' + '' +
                        '<thead>' +
                        '<tr style="background-color:#bfc4dd;font-weight:bold;font-size:12px;color:#333;">' +
                        '<td width="26">#</td>';
                  for (var i = 0; i < Fnum; i++) {
                        var opName = $(".opName1a" + i).val();
                        in_html += '<td width="' + (390 / parseInt(Fnum)) + '" height="25">' + opName + '</td>';
                  }
                  in_html += '<td width="170">시장가/정찰가</td>' +
                        '<td width="170">판매가</td>' +
                        '<td width="170">재고</td>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>' +
                        tr_html +
                        '</tbody>' +
                        '</table>';
                  in_html += '</div>';
                  $(this).parent().after(in_html);




                  $(".AllPrice_check").click(function () {
                        $(".op_commonPrice").each(function () {
                              $(this).val($(".commonPriceAll").val());
                        });
                        $(".op_sellPrice").each(function () {
                              $(this).val($(".sellPriceAll").val());
                        });
                        $(".op_qta").each(function () {
                              $(this).val($(".qtaAll").val());
                        });
                  });

                  //op취소qtBoxa 내용 비움
                  $(".op_cancel").click(function () {
                        $("#qtBoxa").empty();
                  });
                  $(".op_ok").click(function () {
                        //가격선택옵션 갯수
                        var Fnum = $(".optNum").val();
                        var mod = false;
                        var opName1 = "";//옵션명1
                        var opName2 = "";//옵션명2
                        var opName3 = "";//옵션명3
                        var op_commonPrice = "";//시장가/정찰가
                        var op_sellPrice = "";//판매가
                        var op_qta = "";//재고

                        //옵션명1
                        for (var i = 0; i < Fnum; i++) {
                              if (i == 0) {
                                    opName1 = $(".opName1a" + i).val();
                              } else {
                                    opName1 += "/" + $(".opName1a" + i).val();
                              }
                        }
                        var k = 0;
                        $(".opName2a0").each(function () {
                              if (k == 0) {
                                    opName2 = $(this).val();
                              } else {
                                    opName2 += ";" + $(this).val();
                              }
                              k++;
                        });
                        k = 0;
                        $(".opName2a1").each(function () {
                              if (k == 0) {
                                    opName2 += "/" + $(this).val();
                              } else {
                                    opName2 += ";" + $(this).val();
                              }
                              k++;
                        });
                        if (Fnum == "3") {
                              k = 0;
                              $(".opName2a2").each(function () {
                                    if (k == 0) {
                                          opName2 += "/" + $(this).val();
                                    } else {
                                          opName2 += ";" + $(this).val();
                                    }
                                    k++;
                              });
                        }

                        k = 0;
                        $(".op_commonPrice").each(function () {
                              if (k == 0) {
                                    op_commonPrice = $(this).val();
                              } else {
                                      op_commonPrice += ";" + $(this).val();
                              }
                              if ($(this).val().trim() == "") {
                                    mod = true;
                                    $(this).focus();
                              }
                              k++;
                        });
                        k = 0;
                        j = 0;
                        $(".op_sellPrice").each(function () {
                              if (k == 0) {
                                    op_sellPrice = $(this).val();
                              } else {
                                      op_sellPrice += ";" + $(this).val();
                              }
                              if ($(this).val().trim() == "") {
                                    mod = true;
                                    $(this).focus();
                              }
                              k++;
                        });
                        k = 0;
                        $(".op_qta").each(function () {
                              if (k == 0) {
                                    op_qta = $(this).val();
                              } else {
                                      op_qta += ";" + $(this).val();
                              }
                              if ($(this).val().trim() == "") {
                                    mod = true;
                                    $(this).focus();
                              }
                              k++;
                        });
                        if (mod == true) {
                              alert("빈 내용을 전부 입력해 주세요.");
                              return false;
                        }
                        $("#opName1").val(opName1);
                        $("#opName2").val(opName2);
                        $("#commonPrice").val(op_commonPrice);
                        $("#sellPrice").val(op_sellPrice);
                        $("#qta").val(op_qta);
                        $("#qtBoxa").empty();
                  });
            });

            if (str == "a" && strVal == "2") {
                  var opName1 = $("#opName1").val();
                  if (opName1 != "") {
                        var opName1Arr = opName1.split("/");
                        var commonPrice = $("#commonPrice").val();
                        var sellPrice = $("#sellPrice").val();
                        var qta = $("#qta").val();
                        var commonPriceArr = commonPrice.split(";");
                        var sellPriceArr = sellPrice.split(";");
                        var qtaArr = qta.split(";");
                        cc = 0;
                        $(".optNum").selectedIndex
                        $(".optNum").prop('selectedIndex', opName1Arr.length - 1);
                        $(".optNum").attr("disabled", "disabled");
                        for (var i = 0; i < opName1Arr.length; i++) {
                              $(".add_box" + str).trigger("click");
                              var opName2 = $("#opName2").val();
                              var opName2Arr = opName2.split("/");
                              for (var j = 0; j < opName2Arr.length; j++) {
                                    var opName2Arr2 = opName2Arr[i];
                                    var opName2Arr3 = opName2Arr2.split(";");
                              }
                              for (var n = 0; n < opName2Arr3.length - 1; n++) {
                                    $(".add_option" + str + i).trigger("click");
                              }
                              $(".opName1a" + i).val(opName1Arr[i]);
                              var k = 0;
                              $(".opName2a" + i).each(function () {
                                    $(this).val(opName2Arr3[k]);
                                    k++;
                              });
                        }
                        $(".grid_box").trigger("click");
                        k = 0;
                        $(".op_commonPrice").each(function () {
                              $(this).val(commonPriceArr[k]);
                              k++;
                        });
                        k = 0;
                        $(".op_sellPrice").each(function () {
                              $(this).val(sellPriceArr[k]);
                              k++;
                        });
                        k = 0;
                        $(".op_qta").each(function () {
                              $(this).val(qtaArr[k]);
                              k++;
                        });
                  }
            }
      }


      //0일반배송  1별도배송
      var chkVal;
      $(".dlv_special").click(function () {
            $(this).each(function () {
                  if ($(this).attr("checked") == "checked") {
                        chkVal = $(this).val();
                        if (chkVal == "0") {
                              $(".goods_dlv_special0").show();
                              $(".goods_dlv_special1").hide();
                              $(".goods_dlv_special0 input[value=1]").attr("checked", true);
                              $(".dlv_txt").text("판매자 기본 배송정책 적용: 고정금액(선불) / 배송료 : 2500원 / 지역할증 : 있음");
                              $(".dlv_fee").hide();
                              $(".dlv_dd").css("height", "70px");
                        } else {
                              $(".goods_dlv_special1").show();
                              $(".goods_dlv_special0").hide();
                              $(".goods_dlv_special1 input[value=2]").attr("checked", true);
                              $(".dlv_dd").css("height", "170px");
                        }
                  }
            });
      });
      $("input[name=goods_dlv_type]").click(function () {
            //goods_dlv_type val
            var dlv_type_val;
            $(this).each(function () {
                  if ($(this).attr("checked") == "checked") {
                        dlv_type_val = $(this).val();
                  }
                  if (chkVal == undefined) {
                        chkVal = "0";
                  }
            });
            if (chkVal == "0") {
                  if (dlv_type_val == "1") {
                        $(".dlv_txt").text("판매자 기본 배송정책 적용: 고정금액(선불) / 배송료 : 2500원 / 지역할증 : 있음");
                        $(".dlv_fee").hide();
                  } else if (dlv_type_val == "2") {
                        $(".dlv_txt").text("배송비 무료");
                        $(".dlv_fee").hide();
                  } else if (dlv_type_val == "3") {
                        $(".dlv_txt").text("고정금액");
                        $(".dlv_fee").show();
                        $(".dlv_won").show();
                  }
            } else {

            }
      });

      function goods_opt_grid_del(num){
            //delete json.SEX;
            if(num == 1){

            }else if(num == 2){

            }else{

            }
      }
      function goods_opt_grid(Fnum){
            if (Fnum == "2") {
                  var len1 = $(".opName2a0").length;
                  var len2 = $(".opName2a1").length;
                  people ='{';
                  var n=1;
                  for (var i = 0; i < len1; i++) {
                        people +='"_'+$(".opName2a0")[i].value+'": [';
                        people += '{ ';
                        for (var j = 0; j < len2; j++) {
                              people +='"_'+$(".opName2a1")[i].value+'": [';
                              people += '{"_시장가":"'+$(".op_commonPrice"+n).val()+'","_판매가":"'+$(".op_sellPrice"+n).val()+'","_재고":"'+$(".op_qta"+n).val()+'"}';
                              if(j == len2-1){
                                    people +=']';
                              }else{
                                    people +='],';
                              }
                        }
                        people += '}';
                        if(i == len1-1){
                              people += ']';
                        }else{
                              people += '],';
                        }
                  }
                  people += '}';
                  var objTEST = eval("(" + people + ")");
            } else if (Fnum == "3") {
                  var len1 = $(".opName2a0").length;
                  var len2 = $(".opName2a1").length;
                  var len3 = $(".opName2a2").length;
                  var n = 1;
                  people ='{';
                  for (var i = 0; i < len1; i++) {
                        people +='"_'+$(".opName2a0")[i].value+'": [';
                        people += '{ ';
                        for (var j = 0; j < len2; j++) {
                              people += '"_'+$(".opName2a1")[j].value+'": [';
                              people +=  '{';
                              for(var k=0;k<len3;k++){
                                    people += '"_'+$(".opName2a2")[k].value+'": [';
                                    people += '{"opValue1":"'+$(".op_commonPrice"+n).val()+'","opValue2":"'+$(".op_sellPrice"+n).val()+'","qta":"'+$(".op_qta"+n).val()+'"}';
                                    if(k == len3-1){
                                          people +=']';
                                    }else{
                                          people +='],';
                                    }
                                    n++;
                              }
                              people += '}';
                              if(j == len2-1){
                                    people += ']';
                              }else{
                                    people += '],';
                              }
                        }
                        people += '}';
                        if(i == len1-1){
                              people += ']';
                        }else{
                              people += '],';
                        }
                  }
                  people += '}';
                  $("#editor2").html(people);
                  //var objTEST = eval("(" + people + ")");
                  //alert(objTEST._아디다스[0]._블루[0]._255[0].qta);
            }
      }
      function json_each(Fnum,name1,name2,name3,k7){
            var objjson = eval("(" + people + ")");
            name1 = "_"+name1;
            name2 = "_"+name2;
            name3 = "_"+name3;
            var tr_html="";
            if(Fnum == "2"){

            }else{
                  $.each(objjson, function(k, v) {
                        var opName1 = k;
                        $.each(v, function(k1, v1) {
                              $.each(v1, function(k2, v2) {
                                    var opName2 = k2;
                                    $.each(v2, function(k3, v3) {
                                          $.each(v3, function(k4, v4) {
                                                var opName3 = k4;
                                                $.each(v4, function(k5, v5) {
                                                      var i = 0;
                                                      $.each(v5, function(k6, v6) {
                                                            if(opName1 == name1 && opName2==name2 && opName3 == name3 && v6 != undefined){
                                                                  if(i == 0){
                                                                        tr_html += '<td><input class="border op_commonPrice op_commonPrice' + k7 + '" style="width:99%;background-color:#3a5795;color:white;" type="text" value="'+v6+'"></td>';
                                                                  }else if(i == 1){
                                                                        tr_html += '<td><input class="border op_sellPrice op_sellPrice' + k7 + '" style="width:99%;background-color:#3a5795;color:white;" type="text" value="'+v6+'"></td>';
                                                                  }else{
                                                                        tr_html += '<td><input class="border op_qta op_qta' + k7 + '" style="width:99%;background-color:#3a5795;color:white;" type="text" value="'+v6+'"></td>';
                                                                  }
                                                            }
                                                            i++;
                                                            //alert(k6 + ' ' + v6 + '  ' + n);
                                                      });
                                                });
                                          });
                                    });
                              });
                        });
                  });
            }
            //alert(tr_html);
            return tr_html;
      }
});