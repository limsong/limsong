<script type="text/javascript" src="se2/js/HuskyEZCreator.js" charset="utf-8"></script>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet light form-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red bold uppercase">판매자 안내문구</span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal form-bordered">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">결제안내</label>
                            <div class="col-md-9">
                                <textarea name="ir1" id="ir1" rows="15" class="col-md-11"></textarea>
                                <script type="text/javascript">
                                    var oEditors = [];
                                    nhn.husky.EZCreator.createInIFrame({
                                        oAppRef: oEditors,
                                        elPlaceHolder: "ir1",
                                        sSkinURI: "se2/SmartEditor2Skin.html",
                                        fCreator: "createSEditor2"
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">배송안내</label>
                            <div class="col-md-9">
                                <textarea name="ir2" id="ir2" rows="15" class="col-md-11"></textarea>
                                <script type="text/javascript">
                                    var oEditors = [];
                                    nhn.husky.EZCreator.createInIFrame({
                                        oAppRef: oEditors,
                                        elPlaceHolder: "ir2",
                                        sSkinURI: "se2/SmartEditor2Skin.html",
                                        fCreator: "createSEditor2"
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">교환/반품안내</label>
                            <div class="col-md-9">
                                <textarea name="ir3" id="ir3" rows="15" class="col-md-11"></textarea>
                                <script type="text/javascript">
                                    var oEditors = [];
                                    nhn.husky.EZCreator.createInIFrame({
                                        oAppRef: oEditors,
                                        elPlaceHolder: "ir3",
                                        sSkinURI: "se2/SmartEditor2Skin.html",
                                        fCreator: "createSEditor2"
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">서비스문의안내</label>
                            <div class="col-md-9">
                                <textarea name="ir5" id="ir5" rows="15" class="col-md-11"></textarea>
                                <script type="text/javascript">
                                    var oEditors = [];
                                    nhn.husky.EZCreator.createInIFrame({
                                        oAppRef: oEditors,
                                        elPlaceHolder: "ir5",
                                        sSkinURI: "se2/SmartEditor2Skin.html",
                                        fCreator: "createSEditor2"
                                    });
                                </script>
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