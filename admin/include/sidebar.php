<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <? if($ch==""){ ?>
            <li class="nav-item start active open">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                    <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start active open">
                        <a href="../index.html" class="nav-link ">
                            <i class="icon-bar-chart"></i>
                            <span class="title">Dashboard 1</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="../dashboard_2.html" class="nav-link ">
                            <i class="icon-bulb"></i>
                            <span class="title">Dashboard 2</span>
                            <span class="badge badge-success">1</span>
                        </a>
                    </li>
                    <li class="nav-item start ">
                        <a href="../dashboard_3.html" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">Dashboard 3</span>
                            <span class="badge badge-danger">5</span>
                        </a>
                    </li>
                </ul>
            </li>
            <?}?>
            <? if($ch=="shop"){ ?>
            <li class="heading">
                <h3 class="uppercase">기본설정</h3>
            </li>
            <li class="nav-item start active open">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">판매자 기본설정</span>
                    <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <? if($act=='seller_info') echo 'start active open'; ?>">
                        <a href="?act=seller_info&ch=shop&title=기본설정&title_name=판매자 기본정보" class="nav-link ">
                            <span class="title">판매자 기본정보</span>
                            <? if($act=='seller_info') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                    <li class="nav-item <? if($act=='shop_policy_delivery') echo 'start active open'; ?>">
                        <a href="?act=shop_policy_delivery&ch=shop&title=기본설정&title_name=판매자 배송정책" class="nav-link ">
                            <span class="title">판매자 배송정책</span>
                            <? if($act=='shop_policy_delivery') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                    <li class="nav-item <? if($act=='seller_policy_info') echo 'start active open'; ?>">
                        <a href="?act=seller_policy_info&ch=shop&title=기본설정&title_name=판매자 안내문구" class="nav-link ">
                            <span class="title">판매자 안내문구</span>
                            <? if($act=='seller_policy_info') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                </ul>
            </li>
            <?}?>
            <? if($ch=="user"){ ?>
                <li class="heading">
                    <h3 class="uppercase">회원관리</h3>
                </li>
                <li class="nav-item start active open">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-diamond"></i>
                        <span class="title">회원관리</span>
                        <span class="arrow open"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item <? if($act=='user_info_list') echo 'start active open'; ?>">
                            <a href="?act=user_info_list&ch=user&title=회원관리&title_name=회원리스트" class="nav-link ">
                                <span class="title">회원 리스트</span>
                                <? if($act=='user_info_list') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='user_policy_leve') echo 'start active open'; ?>">
                            <a href="?act=user_policy_leve&ch=user&title=회원관리&title_name=회원등급 관리" class="nav-link ">
                                <span class="title">회원등급 관리</span>
                                <? if($act=='user_policy_leve') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='user_info_sleep_list') echo 'start active open'; ?>">
                            <a href="?act=user_info_sleep_list&ch=user&title=회원관리&title_name=휴면회원 리스트" class="nav-link ">
                                <span class="title">휴면회원 리스트</span>
                                <? if($act=='user_info_sleep_list') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='user_info_secede_list') echo 'start active open'; ?>">
                            <a href="?act=user_info_secede_list&ch=user&title=회원관리&title_name=탈퇴회원 리스트" class="nav-link ">
                                <span class="title">탈퇴회원 리스트</span>
                                <? if($act=='user_info_secede_list') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item start active open">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-diamond"></i>
                        <span class="title">마케팅그룹 관리</span>
                        <span class="arrow open"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item <? if($act=='user_market_group_list') echo 'start active open'; ?>">
                            <a href="?act=user_market_group_list&ch=user&title=회원관리&title_name=마케팅그룹리스트" class="nav-link ">
                                <span class="title">마케팅그룹 리스트</span>
                                <? if($act=='user_market_group_list') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='user_market_group_step1_write') echo 'start active open'; ?>">
                            <a href="?act=user_market_group_step1_write&ch=user&title=회원관리&title_name=마케팅그룹 등록" class="nav-link ">
                                <span class="title">마케팅그룹 등록</span>
                                <? if($act=='user_market_group_step1_write') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item start active open">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-diamond"></i>
                        <span class="title">메일/문자</span>
                        <span class="arrow open"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item <? if($act=='user_mail_write') echo 'start active open'; ?>">
                            <a href="?act=user_mail_write&ch=user&title=회원관리&title_name=메일 발송" class="nav-link ">
                                <span class="title">메일 발송</span>
                                <? if($act=='user_mail_write') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='user_sms_write') echo 'start active open'; ?>">
                            <a href="?act=user_sms_write&ch=user&title=회원관리&title_name=문자 발송" class="nav-link ">
                                <span class="title">문자 발송</span>
                                <? if($act=='user_sms_write') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='user_mail_auto_setup') echo 'start active open'; ?>">
                            <a href="?act=user_mail_auto_setup&ch=user&title=회원관리&title_name=자동 메일 설정" class="nav-link ">
                                <span class="title">자동 메일 설정</span>
                                <? if($act=='user_mail_auto_setup') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='user_sms_auto_setup') echo 'start active open'; ?>">
                            <a href="?act=user_sms_auto_setup&ch=user&title=회원관리&title_name=자동 문자 설정" class="nav-link ">
                                <span class="title">자동 문자 설정</span>
                                <? if($act=='user_sms_auto_setup') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='user_mail_manage') echo 'start active open'; ?>">
                            <a href="?act=user_mail_manage&ch=user&title=회원관리&title_name=메일 관리" class="nav-link ">
                                <span class="title">메일 관리</span>
                                <? if($act=='user_mail_manage') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='user_sms_manage') echo 'start active open'; ?>">
                            <a href="?act=user_sms_manage&ch=user&title=회원관리&title_name=문자 관리" class="nav-link ">
                                <span class="title">문자 관리</span>
                                <? if($act=='user_sms_manage') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item start active open">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-diamond"></i>
                        <span class="title">회원이용도</span>
                        <span class="arrow open"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item <? if($act=='user_access_mile') echo 'start active open'; ?>">
                            <a href="?act=user_access_mile&ch=user&title=회원관리&title_name=적립금 로그" class="nav-link ">
                                <span class="title">적립금 로그</span>
                                <? if($act=='user_access_mile') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='user_access_mile_keep') echo 'start active open'; ?>">
                            <a href="?act=user_access_mile_keep&ch=user&title=회원관리&title_name=적립금 순위" class="nav-link ">
                                <span class="title">적립금 순위</span>
                                <? if($act=='user_access_mile_keep') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='user_access_recm_user') echo 'start active open'; ?>">
                            <a href="?act=user_access_recm_user&ch=user&title=회원관리&title_name=추천인 순위" class="nav-link ">
                                <span class="title">추천인 순위</span>
                                <? if($act=='user_access_recm_user') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='user_access_coupon') echo 'start active open'; ?>">
                            <a href="?act=user_access_coupon&ch=user&title=회원관리&title_name=쿠폰 로그" class="nav-link ">
                                <span class="title">쿠폰 로그</span>
                                <? if($act=='user_access_coupon') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='user_access_coupon_keep') echo 'start active open'; ?>">
                            <a href="?act=user_access_coupon_keep&ch=user&title=회원관리&title_name=쿠폰 순위" class="nav-link ">
                                <span class="title">쿠폰 순위</span>
                                <? if($act=='user_access_coupon_keep') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                    </ul>
                </li>
            <?}?>
            <? if($ch=="goods"){ ?>
            <!-- 상품 관리 -->
            <li class="heading">
                <h3 class="uppercase">상품관리</h3>
            </li>
            <li class="nav-item start active open">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-tag"></i>
                    <span class="title">상품관리</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <? if($act=='goods_lis') echo 'start active open'; ?>">
                        <a href="?act=goods_lis&ch=goods&title=상품관리&title_name=상품 리스트" class="nav-link ">
                            <span class="title">상품 리스트</span>
                            <? if($act=='goods_lis') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                    <li class="nav-item <? if($act=='goods_lis') echo 'start active open'; ?>">
                        <a href="?act=goods_form&ch=goods&title=상품관리&title_name=상품 등록" class="nav-link ">
                            <span class="title">상품 등록</span>
                            <? if($act=='goods_form') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                </ul>
            </li>
            <?}?>
            <? if($ch=="order"){ ?>
            <li class="heading">
                <h3 class="uppercase">주문관리</h3>
            </li>
            <li class="nav-item start active open">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-basket"></i>
                    <span class="title">주문 관리</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <? if($act=='buy_pay_wait_list') echo 'start active open'; ?>">
                        <a href="?act=buy_pay_wait_list&ch=order&title=주문관리&title_name=입금대기" class="nav-link ">
                            <i class="icon-home"></i>
                            <span class="title">입금대기</span>
                            <span class="badge badge-danger">0</span>
                            <? if($act=='buy_pay_wait_list') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                    <li class="nav-item <? if($act=='buy_pay_ok_list') echo 'start active open'; ?>">
                        <a href="?act=buy_pay_ok_list=ch=order&title=주문관리&title_name=입금완료" class="nav-link ">
                            <i class="icon-basket"></i>
                            <span class="title">입금완료</span>
                            <span class="badge badge-danger">0</span>
                            <? if($act=='buy_pay_ok_list') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                    <li class="nav-item <? if($act=='buy_dlv_wait_list') echo 'start active open'; ?>">
                        <a href="?act=buy_dlv_wait_list&ch=order&title=주문관리&title_name=배송요청" class="nav-link ">
                            <i class="icon-tag"></i>
                            <span class="title">배송요청</span>
                            <span class="badge badge-danger">0</span>
                            <? if($act=='buy_dlv_wait_list') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                    <li class="nav-item <? if($act=='buy_dlv_int_list') echo 'start active open'; ?>">
                        <a href="?act=buy_dlv_int_list&ch=order&title=주문관리&title_name=배송중" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">배송중</span>
                            <span class="badge badge-danger">0</span>
                            <? if($act=='buy_dlv_int_list') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                    <li class="nav-item <? if($act=='buy_dlv_ok_list') echo 'start active open'; ?>">
                        <a href="?act=buy_dlv_ok_list&ch=order&title=주문관리&title_name=구매확정" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">구매확정</span>
                            <span class="badge badge-danger">0</span>
                            <? if($act=='buy_dlv_ok_list') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                    <li class="nav-item <? if($act=='buy_return_wait_list') echo 'start active open'; ?>">
                        <a href="?act=buy_return_wait_list&ch=order&title=주문관리&title_name=배송후 반품" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">배송후 반품</span>
                            <span class="badge badge-danger">0</span>
                            <? if($act=='buy_return_wait_list') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                    <li class="nav-item <? if($act=='buy_exch_wait_list') echo 'start active open'; ?>">
                        <a href="?act=buy_exch_wait_list&ch=order&title=주문관리&title_name=베송후 교환" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">베송후 교환</span>
                            <span class="badge badge-danger">0</span>
                            <? if($act=='buy_exch_wait_list') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                    <li class="nav-item <? if($act=='buy_order_list') echo 'start active open'; ?>">
                        <a href="?act=buy_order_list&ch=order&title=상품관리&title_name=주문리스트(전체)" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">주문리스트(전체)</span>
                            <span class="badge badge-danger">0</span>
                            <? if($act=='buy_order_list') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                </ul>
            </li>
            <?}?>
            <? if($ch=="community"){ ?>
            <li class="heading">
                <h3 class="uppercase">운영관리</h3>
            </li>
            <li class="nav-item start active open">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-note"></i>
                    <span class="title">운영관리</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  <? if($act=='notice') echo 'start active open'; ?>">
                        <a href="?act=notice&ch=community&title=운영관리&title_name=공지사항" class="nav-link ">
                            <i class="icon-call-end"></i>
                            <span class="title">공지사항</span>
                            <? if($act=='notice') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                    <li class="nav-item  <? if($act=='faq') echo 'start active open'; ?>">
                        <a href="?act=faq&ch=community&title=운영관리&title_name=FAQ" class="nav-link ">
                            <i class="icon-tag"></i>
                            <span class="title">FAQ</span>
                            <? if($act=='faq') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                    <li class="nav-item  <? if($act=='board_free') echo 'start active open'; ?>">
                        <a href="?act=board_free&ch=community&title=운영관리&title_name=자유게시판" class="nav-link ">
                            <i class="icon-call-end"></i>
                            <span class="title">자유게시판</span>
                            <? if($act=='board_free') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                    <li class="nav-item  <? if($act=='board_onetoone') echo 'start active open'; ?>">
                        <a href="?act=board_onetoone&ch=community&title=운영관리&title_name=1:1상담 관리" class="nav-link ">
                            <i class="icon-call-end"></i>
                            <span class="title">1:1상담 관리</span>
                            <? if($act=='board_onetoone') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>

                    <li class="nav-item  <? if($act=='goods_qna') echo 'start active open'; ?>">
                        <a href="?act=goods_qna&ch=community&title=운영관리&title_name=상품문의" class="nav-link ">
                            <i class="icon-tag"></i>
                            <span class="title">상품문의</span>
                            <? if($act=='goods_qna') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                    <li class="nav-item  <? if($act=='user_review') echo 'start active open'; ?>">
                        <a href="?act=user_review&ch=community&title=운영관리&title_name=사용후기" class="nav-link ">
                            <i class="icon-tag"></i>
                            <span class="title">사용후기</span>
                            <? if($act=='user_review') echo '<span class="selected"></span>'; ?>
                        </a>
                    </li>
                </ul>
            </li>
            <?}?>
            <? if($ch=="event"){ ?>
                <li class="heading">
                    <h3 class="uppercase">프로모션</h3>
                </li>
                <li class="nav-item start active open">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-note"></i>
                        <span class="title">이벤트 관리</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item <? if($act=='event_list') echo 'start active open'; ?>">
                            <a href="?act=event_list&ch=event&title=프로모션&title_name=공지사항" class="nav-link ">
                                <i class="icon-call-end"></i>
                                <span class="title">이벤트 관리</span>
                                <? if($act=='event_list') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='popup_list') echo 'start active open'; ?>">
                            <a href="?act=popup_list&ch=event&title=프로모션&title_name=팝업창 관리" class="nav-link ">
                                <i class="icon-tag"></i>
                                <span class="title">팝업창 관리</span>
                                <? if($act=='popup_list') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='banner_list') echo 'start active open'; ?>">
                            <a href="?act=banner_list&ch=event&title=프로모션&title_name=배너 관리" class="nav-link ">
                                <i class="icon-call-end"></i>
                                <span class="title">배너 관리</span>
                                <? if($act=='banner_list') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                        <li class="nav-item <? if($act=='poll_manage') echo 'start active open'; ?>">
                            <a href="?act=poll_manage&ch=event&title=프로모션&title_name=온라인 설문 관리" class="nav-link ">
                                <i class="icon-call-end"></i>
                                <span class="title">온라인 설문 관리</span>
                                <? if($act=='poll_manage') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>

                        <li class="nav-item <? if($act=='attendance_event') echo 'start active open'; ?>">
                            <a href="?act=attendance_event&ch=event&title=프로모션&title_name=출석체크 설정" class="nav-link ">
                                <i class="icon-tag"></i>
                                <span class="title">출석체크 설정</span>
                                <? if($act=='attendance_event') echo '<span class="selected"></span>'; ?>
                            </a>
                        </li>
                    </ul>
                </li>
            <?}?>
            <li class="heading">
                <h3 class="uppercase">Features</h3>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">UI Features</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="ui_colors.html" class="nav-link ">
                            <span class="title">Color Library</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_general.html" class="nav-link ">
                            <span class="title">General Components</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_buttons.html" class="nav-link ">
                            <span class="title">Buttons</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_buttons_spinner.html" class="nav-link ">
                            <span class="title">Spinner Buttons</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_confirmations.html" class="nav-link ">
                            <span class="title">Popover Confirmations</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_sweetalert.html" class="nav-link ">
                            <span class="title">Bootstrap Sweet Alerts</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_icons.html" class="nav-link ">
                            <span class="title">Font Icons</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_socicons.html" class="nav-link ">
                            <span class="title">Social Icons</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_typography.html" class="nav-link ">
                            <span class="title">Typography</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_tabs_accordions_navs.html" class="nav-link ">
                            <span class="title">Tabs, Accordions & Navs</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_timeline.html" class="nav-link ">
                            <span class="title">Timeline 1</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_timeline_2.html" class="nav-link ">
                            <span class="title">Timeline 2</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_timeline_horizontal.html" class="nav-link ">
                            <span class="title">Horizontal Timeline</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_tree.html" class="nav-link ">
                            <span class="title">Tree View</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <span class="title">Page Progress Bar</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item ">
                                <a href="ui_page_progress_style_1.html" class="nav-link "> Flash </a>
                            </li>
                            <li class="nav-item ">
                                <a href="ui_page_progress_style_2.html" class="nav-link "> Big Counter </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_blockui.html" class="nav-link ">
                            <span class="title">Block UI</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_bootstrap_growl.html" class="nav-link ">
                            <span class="title">Bootstrap Growl Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_notific8.html" class="nav-link ">
                            <span class="title">Notific8 Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_toastr.html" class="nav-link ">
                            <span class="title">Toastr Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_bootbox.html" class="nav-link ">
                            <span class="title">Bootbox Dialogs</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_alerts_api.html" class="nav-link ">
                            <span class="title">Metronic Alerts API</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_session_timeout.html" class="nav-link ">
                            <span class="title">Session Timeout</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_idle_timeout.html" class="nav-link ">
                            <span class="title">User Idle Timeout</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_modals.html" class="nav-link ">
                            <span class="title">Modals</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_extended_modals.html" class="nav-link ">
                            <span class="title">Extended Modals</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_tiles.html" class="nav-link ">
                            <span class="title">Tiles</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_datepaginator.html" class="nav-link ">
                            <span class="title">Date Paginator</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ui_nestable.html" class="nav-link ">
                            <span class="title">Nestable List</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-puzzle"></i>
                    <span class="title">Components</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="components_date_time_pickers.html" class="nav-link ">
                            <span class="title">Date & Time Pickers</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_color_pickers.html" class="nav-link ">
                            <span class="title">Color Pickers</span>
                            <span class="badge badge-danger">2</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_select2.html" class="nav-link ">
                            <span class="title">Select2 Dropdowns</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_bootstrap_multiselect_dropdown.html" class="nav-link ">
                            <span class="title">Bootstrap Multiselect Dropdowns</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_bootstrap_select.html" class="nav-link ">
                            <span class="title">Bootstrap Select</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_multi_select.html" class="nav-link ">
                            <span class="title">Bootstrap Multiple Select</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_bootstrap_select_splitter.html" class="nav-link ">
                            <span class="title">Select Splitter</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_clipboard.html" class="nav-link ">
                            <span class="title">Clipboard</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_typeahead.html" class="nav-link ">
                            <span class="title">Typeahead Autocomplete</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_bootstrap_tagsinput.html" class="nav-link ">
                            <span class="title">Bootstrap Tagsinput</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_bootstrap_switch.html" class="nav-link ">
                            <span class="title">Bootstrap Switch</span>
                            <span class="badge badge-success">6</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_bootstrap_maxlength.html" class="nav-link ">
                            <span class="title">Bootstrap Maxlength</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_bootstrap_fileinput.html" class="nav-link ">
                            <span class="title">Bootstrap File Input</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_bootstrap_touchspin.html" class="nav-link ">
                            <span class="title">Bootstrap Touchspin</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_form_tools.html" class="nav-link ">
                            <span class="title">Form Widgets & Tools</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_context_menu.html" class="nav-link ">
                            <span class="title">Context Menu</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_editors.html" class="nav-link ">
                            <span class="title">Markdown & WYSIWYG Editors</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_code_editors.html" class="nav-link ">
                            <span class="title">Code Editors</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_ion_sliders.html" class="nav-link ">
                            <span class="title">Ion Range Sliders</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_noui_sliders.html" class="nav-link ">
                            <span class="title">NoUI Range Sliders</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="components_knob_dials.html" class="nav-link ">
                            <span class="title">Knob Circle Dials</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">Form Stuff</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="form_controls.html" class="nav-link ">
                                        <span class="title">Bootstrap Form
                                            <br>Controls</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="form_controls_md.html" class="nav-link ">
                                        <span class="title">Material Design
                                            <br>Form Controls</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="form_validation.html" class="nav-link ">
                            <span class="title">Form Validation</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="form_validation_states_md.html" class="nav-link ">
                                        <span class="title">Material Design
                                            <br>Form Validation States</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="form_validation_md.html" class="nav-link ">
                                        <span class="title">Material Design
                                            <br>Form Validation</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="form_layouts.html" class="nav-link ">
                            <span class="title">Form Layouts</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="form_repeater.html" class="nav-link ">
                            <span class="title">Form Repeater</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="form_input_mask.html" class="nav-link ">
                            <span class="title">Form Input Mask</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="form_editable.html" class="nav-link ">
                            <span class="title">Form X-editable</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="form_wizard.html" class="nav-link ">
                            <span class="title">Form Wizard</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="form_icheck.html" class="nav-link ">
                            <span class="title">iCheck Controls</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="form_image_crop.html" class="nav-link ">
                            <span class="title">Image Cropping</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="form_fileupload.html" class="nav-link ">
                            <span class="title">Multiple File Upload</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="form_dropzone.html" class="nav-link ">
                            <span class="title">Dropzone File Upload</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-bulb"></i>
                    <span class="title">Elements</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="elements_steps.html" class="nav-link ">
                            <span class="title">Steps</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="elements_lists.html" class="nav-link ">
                            <span class="title">Lists</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="elements_ribbons.html" class="nav-link ">
                            <span class="title">Ribbons</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="elements_overlay.html" class="nav-link ">
                            <span class="title">Overlays</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="elements_cards.html" class="nav-link ">
                            <span class="title">User Cards</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-briefcase"></i>
                    <span class="title">Tables</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="table_static_basic.html" class="nav-link ">
                            <span class="title">Basic Tables</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="table_static_responsive.html" class="nav-link ">
                            <span class="title">Responsive Tables</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="table_bootstrap.html" class="nav-link ">
                            <span class="title">Bootstrap Tables</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <span class="title">Datatables</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item ">
                                <a href="table_datatables_managed.html" class="nav-link "> Managed Datatables </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_buttons.html" class="nav-link "> Buttons Extension </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_colreorder.html" class="nav-link "> Colreorder Extension </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_rowreorder.html" class="nav-link "> Rowreorder Extension </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_scroller.html" class="nav-link "> Scroller Extension </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_fixedheader.html" class="nav-link "> FixedHeader Extension </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_responsive.html" class="nav-link "> Responsive Extension </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_editable.html" class="nav-link "> Editable Datatables </a>
                            </li>
                            <li class="nav-item ">
                                <a href="table_datatables_ajax.html" class="nav-link "> Ajax Datatables </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="index-p=.html" class="nav-link nav-toggle">
                    <i class="icon-wallet"></i>
                    <span class="title">Portlets</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="portlet_boxed.html" class="nav-link ">
                            <span class="title">Boxed Portlets</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="portlet_light.html" class="nav-link ">
                            <span class="title">Light Portlets</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="portlet_solid.html" class="nav-link ">
                            <span class="title">Solid Portlets</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="portlet_ajax.html" class="nav-link ">
                            <span class="title">Ajax Portlets</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="portlet_draggable.html" class="nav-link ">
                            <span class="title">Draggable Portlets</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Charts</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="charts_amcharts.html" class="nav-link ">
                            <span class="title">amChart</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="charts_flotcharts.html" class="nav-link ">
                            <span class="title">Flot Charts</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="charts_flowchart.html" class="nav-link ">
                            <span class="title">Flow Charts</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="charts_google.html" class="nav-link ">
                            <span class="title">Google Charts</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="charts_echarts.html" class="nav-link ">
                            <span class="title">eCharts</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="charts_morris.html" class="nav-link ">
                            <span class="title">Morris Charts</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <span class="title">HighCharts</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item ">
                                <a href="charts_highcharts.html" class="nav-link "> HighCharts </a>
                            </li>
                            <li class="nav-item ">
                                <a href="charts_highstock.html" class="nav-link "> HighStock </a>
                            </li>
                            <li class="nav-item ">
                                <a href="charts_highmaps.html" class="nav-link "> HighMaps </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-pointer"></i>
                    <span class="title">Maps</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="maps_google.html" class="nav-link ">
                            <span class="title">Google Maps</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="maps_vector.html" class="nav-link ">
                            <span class="title">Vector Maps</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="heading">
                <h3 class="uppercase">Layouts</h3>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-layers"></i>
                    <span class="title">Page Layouts</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="layout_blank_page.html" class="nav-link ">
                            <span class="title">Blank Page</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="layout_ajax_page.html" class="nav-link ">
                            <span class="title">Ajax Content Layout</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="layout_language_bar.html" class="nav-link ">
                            <span class="title">Header Language Bar</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="layout_footer_fixed.html" class="nav-link ">
                            <span class="title">Fixed Footer</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="layout_boxed_page.html" class="nav-link ">
                            <span class="title">Boxed Page</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-feed"></i>
                    <span class="title">Sidebar Layouts</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="layout_sidebar_menu_hover.html" class="nav-link ">
                            <span class="title">Hover Sidebar Menu</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="layout_sidebar_reversed.html" class="nav-link ">
                            <span class="title">Reversed Sidebar Page</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="layout_sidebar_fixed.html" class="nav-link ">
                            <span class="title">Fixed Sidebar Layout</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="layout_sidebar_closed.html" class="nav-link ">
                            <span class="title">Closed Sidebar Layout</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class=" icon-wrench"></i>
                    <span class="title">Custom Layouts</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="layout_disabled_menu.html" class="nav-link ">
                            <span class="title">Disabled Menu Links</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="heading">
                <h3 class="uppercase">Pages</h3>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-basket"></i>
                    <span class="title">eCommerce</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="ecommerce_index.html" class="nav-link ">
                            <i class="icon-home"></i>
                            <span class="title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ecommerce_orders.html" class="nav-link ">
                            <i class="icon-basket"></i>
                            <span class="title">Orders</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ecommerce_orders_view.html" class="nav-link ">
                            <i class="icon-tag"></i>
                            <span class="title">Order View</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ecommerce_products.html" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">Products</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="ecommerce_products_edit.html" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">Product Edit</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-docs"></i>
                    <span class="title">Apps</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="app_todo.html" class="nav-link ">
                            <i class="icon-clock"></i>
                            <span class="title">Todo 1</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="app_todo_2.html" class="nav-link ">
                            <i class="icon-check"></i>
                            <span class="title">Todo 2</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="app_inbox.html" class="nav-link ">
                            <i class="icon-envelope"></i>
                            <span class="title">Inbox</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="app_calendar.html" class="nav-link ">
                            <i class="icon-calendar"></i>
                            <span class="title">Calendar</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="app_ticket.html" class="nav-link ">
                            <i class="icon-notebook"></i>
                            <span class="title">Support</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-user"></i>
                    <span class="title">User</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="page_user_profile_1.html" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">Profile 1</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_user_profile_1_account.html" class="nav-link ">
                            <i class="icon-user-female"></i>
                            <span class="title">Profile 1 Account</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_user_profile_1_help.html" class="nav-link ">
                            <i class="icon-user-following"></i>
                            <span class="title">Profile 1 Help</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_user_profile_2.html" class="nav-link ">
                            <i class="icon-users"></i>
                            <span class="title">Profile 2</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-notebook"></i>
                            <span class="title">Login</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item ">
                                <a href="page_user_login_1.html" class="nav-link " target="_blank"> Login Page 1 </a>
                            </li>
                            <li class="nav-item ">
                                <a href="page_user_login_2.html" class="nav-link " target="_blank"> Login Page 2 </a>
                            </li>
                            <li class="nav-item ">
                                <a href="page_user_login_3.html" class="nav-link " target="_blank"> Login Page 3 </a>
                            </li>
                            <li class="nav-item ">
                                <a href="page_user_login_4.html" class="nav-link " target="_blank"> Login Page 4 </a>
                            </li>
                            <li class="nav-item ">
                                <a href="page_user_login_5.html" class="nav-link " target="_blank"> Login Page 5 </a>
                            </li>
                            <li class="nav-item ">
                                <a href="page_user_login_6.html" class="nav-link " target="_blank"> Login Page 6 </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_user_lock_1.html" class="nav-link " target="_blank">
                            <i class="icon-lock"></i>
                            <span class="title">Lock Screen 1</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_user_lock_2.html" class="nav-link " target="_blank">
                            <i class="icon-lock-open"></i>
                            <span class="title">Lock Screen 2</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-social-dribbble"></i>
                    <span class="title">General</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="page_general_about.html" class="nav-link ">
                            <i class="icon-info"></i>
                            <span class="title">About</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_general_contact.html" class="nav-link ">
                            <i class="icon-call-end"></i>
                            <span class="title">Contact</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-notebook"></i>
                            <span class="title">Portfolio</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item ">
                                <a href="page_general_portfolio_1.html" class="nav-link "> Portfolio 1 </a>
                            </li>
                            <li class="nav-item ">
                                <a href="page_general_portfolio_2.html" class="nav-link "> Portfolio 2 </a>
                            </li>
                            <li class="nav-item ">
                                <a href="page_general_portfolio_3.html" class="nav-link "> Portfolio 3 </a>
                            </li>
                            <li class="nav-item ">
                                <a href="page_general_portfolio_4.html" class="nav-link "> Portfolio 4 </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item  ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-magnifier"></i>
                            <span class="title">Search</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item ">
                                <a href="page_general_search.html" class="nav-link "> Search 1 </a>
                            </li>
                            <li class="nav-item ">
                                <a href="page_general_search_2.html" class="nav-link "> Search 2 </a>
                            </li>
                            <li class="nav-item ">
                                <a href="page_general_search_3.html" class="nav-link "> Search 3 </a>
                            </li>
                            <li class="nav-item ">
                                <a href="page_general_search_4.html" class="nav-link "> Search 4 </a>
                            </li>
                            <li class="nav-item ">
                                <a href="page_general_search_5.html" class="nav-link "> Search 5 </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_general_pricing.html" class="nav-link ">
                            <i class="icon-tag"></i>
                            <span class="title">Pricing</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_general_faq.html" class="nav-link ">
                            <i class="icon-wrench"></i>
                            <span class="title">FAQ</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_general_blog.html" class="nav-link ">
                            <i class="icon-pencil"></i>
                            <span class="title">Blog</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_general_blog_post.html" class="nav-link ">
                            <i class="icon-note"></i>
                            <span class="title">Blog Post</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_general_invoice.html" class="nav-link ">
                            <i class="icon-envelope"></i>
                            <span class="title">Invoice</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_general_invoice_2.html" class="nav-link ">
                            <i class="icon-envelope"></i>
                            <span class="title">Invoice 2</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">System</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="page_cookie_consent_1.html" class="nav-link ">
                            <span class="title">Cookie Consent 1</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_cookie_consent_2.html" class="nav-link ">
                            <span class="title">Cookie Consent 2</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_system_coming_soon.html" class="nav-link " target="_blank">
                            <span class="title">Coming Soon</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_system_404_1.html" class="nav-link ">
                            <span class="title">404 Page 1</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_system_404_2.html" class="nav-link " target="_blank">
                            <span class="title">404 Page 2</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_system_404_3.html" class="nav-link " target="_blank">
                            <span class="title">404 Page 3</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_system_500_1.html" class="nav-link ">
                            <span class="title">500 Page 1</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="page_system_500_2.html" class="nav-link " target="_blank">
                            <span class="title">500 Page 2</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-folder"></i>
                    <span class="title">Multi Level Menu</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-settings"></i> Item 1
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item">
                                <a href="index-p=dashboard-2.html" target="_blank" class="nav-link">
                                    <i class="icon-user"></i> Arrow Toggle
                                    <span class="arrow nav-toggle"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item">
                                        <a href="index.html#" class="nav-link">
                                            <i class="icon-power"></i> Sample Link 1</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="index.html#" class="nav-link">
                                            <i class="icon-paper-plane"></i> Sample Link 1</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="index.html#" class="nav-link">
                                            <i class="icon-star"></i> Sample Link 1</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="index.html#" class="nav-link">
                                    <i class="icon-camera"></i> Sample Link 1</a>
                            </li>
                            <li class="nav-item">
                                <a href="index.html#" class="nav-link">
                                    <i class="icon-link"></i> Sample Link 2</a>
                            </li>
                            <li class="nav-item">
                                <a href="index.html#" class="nav-link">
                                    <i class="icon-pointer"></i> Sample Link 3</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="index-p=dashboard-2.html" target="_blank" class="nav-link">
                            <i class="icon-globe"></i> Arrow Toggle
                            <span class="arrow nav-toggle"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item">
                                <a href="index.html#" class="nav-link">
                                    <i class="icon-tag"></i> Sample Link 1</a>
                            </li>
                            <li class="nav-item">
                                <a href="index.html#" class="nav-link">
                                    <i class="icon-pencil"></i> Sample Link 1</a>
                            </li>
                            <li class="nav-item">
                                <a href="index.html#" class="nav-link">
                                    <i class="icon-graph"></i> Sample Link 1</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="index.html#" class="nav-link">
                            <i class="icon-bar-chart"></i> Item 3 </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>