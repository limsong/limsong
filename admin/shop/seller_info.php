<style>
    table td {
        padding:2px 0px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet light form-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red bold uppercase">판매자 기본정보 수정</span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal form-bordered">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">판매자ID</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Chee Kin" value="tester" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">비밀번호</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Chee Kin" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">비밀번호 확인</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Chee Kin" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">업체정보</label>
                            <div class="col-md-9">
                                <table style="width:100%;">
                                    <tr>
                                        <td style="width:150px;">업체명</td>
                                        <td>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:150px;">사업자등록번호</td>
                                        <td>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:150px;">통신판매업신고번호</td>
                                        <td>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:150px;">업태</td>
                                        <td>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:150px;">종목</td>
                                        <td>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:150px;">주소</td>
                                        <td>
                                            <table style="width:100%;">
                                                <tr>
                                                    <td>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <input class="form-control" type="text" name="text" value="443098" readonly />
                                                                <span class="input-group-btn">
                                                                    <button id="genpassword" class="btn btn-success" type="button">
                                                                        <i class="fa fa-arrow-left fa-fw" /></i> 우편번호찾기</button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:150px;">대표전화</td>
                                        <td>
                                            <div class="col-md-12">
                                                <select class="form-control input-xsmall" style="display: inline;">
                                                    <option value="">선택</option>
                                                    <option value="02" selected>02</option>
                                                    <option value="031">031</option>
                                                    <option value="032">032</option>
                                                    <option value="033">033</option>
                                                    <option value="041">041</option>
                                                    <option value="042">042</option>
                                                    <option value="043">043</option>
                                                    <option value="044">044</option>
                                                    <option value="050">050</option>
                                                    <option value="051">051</option>
                                                    <option value="052">052</option>
                                                    <option value="053">053</option>
                                                    <option value="054">054</option>
                                                    <option value="055">055</option>
                                                    <option value="060">060</option>
                                                    <option value="061">061</option>
                                                    <option value="062">062</option>
                                                    <option value="063">063</option>
                                                    <option value="064">064</option>
                                                    <option value="070">070</option>
                                                    <option value="010">010</option>
                                                    <option value="011">011</option>
                                                    <option value="016">016</option>
                                                    <option value="017">017</option>
                                                    <option value="018">018</option>
                                                    <option value="019">019</option>
                                                    <option value="0303">0303</option>
                                                </select>
                                                <input type="text" class="form-control input-xsmall" style="display: inline;">
                                                <input type="text" class="form-control input-xsmall" style="display: inline;">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:150px;">팩스</td>
                                        <td>
                                            <div class="col-md-12">
                                                <select class="form-control input-xsmall" style="display: inline;">
                                                    <option value="">선택</option>
                                                    <option value="02" selected>02</option>
                                                    <option value="031">031</option>
                                                    <option value="032">032</option>
                                                    <option value="033">033</option>
                                                    <option value="041">041</option>
                                                    <option value="042">042</option>
                                                    <option value="043">043</option>
                                                    <option value="044">044</option>
                                                    <option value="050">050</option>
                                                    <option value="051">051</option>
                                                    <option value="052">052</option>
                                                    <option value="053">053</option>
                                                    <option value="054">054</option>
                                                    <option value="055">055</option>
                                                    <option value="060">060</option>
                                                    <option value="061">061</option>
                                                    <option value="062">062</option>
                                                    <option value="063">063</option>
                                                    <option value="064">064</option>
                                                    <option value="070">070</option>
                                                    <option value="010">010</option>
                                                    <option value="011">011</option>
                                                    <option value="016">016</option>
                                                    <option value="017">017</option>
                                                    <option value="018">018</option>
                                                    <option value="019">019</option>
                                                    <option value="0303">0303</option>
                                                </select>
                                                <input type="text" class="form-control input-xsmall" style="display: inline;">
                                                <input type="text" class="form-control input-xsmall" style="display: inline;">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:150px;">홈페이지</td>
                                        <td>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">담당자 정보</label>
                            <div class="col-md-9">
                                <table style="width:100%">
                                    <tr>
                                        <td style="width:150px;">담당자명</td>
                                        <td>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:150px;">직위</td>
                                        <td>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:150px;">담당자 전화번호</td>
                                        <td>
                                            <div class="col-md-12">
                                                <select class="form-control input-xsmall" style="display: inline;">
                                                    <option value="">선택</option>
                                                    <option value="02" selected>02</option>
                                                    <option value="031">031</option>
                                                    <option value="032">032</option>
                                                    <option value="033">033</option>
                                                    <option value="041">041</option>
                                                    <option value="042">042</option>
                                                    <option value="043">043</option>
                                                    <option value="044">044</option>
                                                    <option value="050">050</option>
                                                    <option value="051">051</option>
                                                    <option value="052">052</option>
                                                    <option value="053">053</option>
                                                    <option value="054">054</option>
                                                    <option value="055">055</option>
                                                    <option value="060">060</option>
                                                    <option value="061">061</option>
                                                    <option value="062">062</option>
                                                    <option value="063">063</option>
                                                    <option value="064">064</option>
                                                    <option value="070">070</option>
                                                    <option value="010">010</option>
                                                    <option value="011">011</option>
                                                    <option value="016">016</option>
                                                    <option value="017">017</option>
                                                    <option value="018">018</option>
                                                    <option value="019">019</option>
                                                    <option value="0303">0303</option>
                                                </select>
                                                <input type="text" class="form-control input-xsmall" style="display: inline;">
                                                <input type="text" class="form-control input-xsmall" style="display: inline;">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:150px;">담당자 이메일</td>
                                        <td>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control input-small" style="display: inline;">
                                                @
                                                <input type="text" class="form-control input-small" style="display: inline;">
                                                <select class="form-control input-small" style="display: inline;">
                                                    <option value="">직접입력</option>
                                                    <option value="chol.com">chol.com</option>
                                                    <option value="dreamwiz.com">dreamwiz.com</option>
                                                    <option value="empal.com">empal.com</option>
                                                    <option value="freechal.com">freechal.com</option>
                                                    <option value="gmail.com">gmail.com</option>
                                                    <option value="hanafos.com">hanafos.com</option>
                                                    <option value="hanmail.net">hanmail.net</option>
                                                    <option value="hanmir.com">hanmir.com</option>
                                                    <option value="hitel.net">hitel.net</option>
                                                    <option value="hotmail.com">hotmail.com</option>
                                                    <option value="korea.com">korea.com</option>
                                                    <option value="lycos.co.kr">lycos.co.kr</option>
                                                    <option value="nate.com">nate.com</option>
                                                    <option value="naver.com">naver.com</option>
                                                    <option value="netian.com">netian.com</option>
                                                    <option value="paran.com">paran.com</option>
                                                    <option value="yahoo.com">yahoo.com</option>
                                                    <option value="yahoo.co.kr">yahoo.co.kr</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn blue">
                                    <i class="fa fa-check"></i> 적용
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>