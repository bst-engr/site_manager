@extends("layouts.default")

@section('header_styles')
  <link rel="stylesheet" href="{{asset('dist/css/skins/_all-skins.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/tinycolor/angularjs-color-picker.min.css')}}" />
  <link href="{{asset('plugins/angular-xeditable/css/xeditable.css')}}" rel="stylesheet">
  <link rel='stylesheet' href="{{asset('plugins/textAngular/textAngular.css')}}">
@stop

@section('page_title')
Site Manager
@stop

@section('page_sub_title')
Whitelabel Portal Settings
@stop

@section('content')
<!-- Small boxes (Stat box) -->
<section class="content" ng-app="savePortalsApp" ng-controller="savePortalController" ng-cloak >
      
      <!-- Main row -->
      <div class="row" ng-init="state._token='{{csrf_token()}}'">
        <div class="col-xs-12">
          <div class="alert alert-success alert-dismissible alert-box" ng-hide="!state.pusherNotification">
            <button type="button" class="close" aria-hidden="true" ng-click="state.pusherNotification=false">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            <span class="data-container">@{{state.pusherNotification}}.</span>
          </div>
          <div class="box" ng-show="state.step == 1">
            <div class="box-header">
              <h3 class="box-title"><a href="#">Basic Settings</a>
              </h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 250px;">
                  <input type="text" ng-model="table_search" id="table_search" class="form-control pull-right" placeholder="Search" ng-readonly="state.readOnly" ng-keyup="customAutocomplete(companies, 'company_name')">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default btn-primary" ng-click="refreshForm('{{action('PortalsettingsController@loadForm')}}')">Add New</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <span class="form-horizontal" name="myForm">
            <div class="box-body">
                <div class="form-group" ng-class="{'has-error' : baseErrors.site_name[0]}">
                  <label for="inputEmail3" class="col-sm-2 control-label">Site Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" ng-model="baseForm.site_name" placeholder="Site Name">
                    <label class="control-label" for="inputWarning" ng-show="baseErrors.site_name[0]">
                    <i class="fa fa-bell-o"></i>@{{baseErrors.site_name[0]}}</label>
                  </div>
                </div>
                <div class="form-group" ng-class="{'has-error' : baseErrors.site_url[0]}">
                  <label for="inputPassword3" class="col-sm-2 control-label">Site URL</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="" ng-model="baseForm.site_url" placeholder="Site URL">
                    <label class="control-label" for="inputWarning" ng-show="baseErrors.site_url[0]">
                    <i class="fa fa-bell-o"></i>@{{baseErrors.site_url[0]}}</label>
                  </div>
                </div>
                <div class="form-group" ng-class="{'has-error' : baseErrors.loginMessage[0]}">
                  <label for="inputPassword3" class="col-sm-2 control-label">Login Message</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="" ng-model="baseForm.loginMessage" placeholder="Login Message">
                    <label class="control-label" for="inputWarning" ng-show="baseErrors.loginMessage[0]">
                    <i class="fa fa-bell-o"></i>@{{baseErrors.loginMessage[0]}}</label>
                  </div>
                </div>
                
                <div class="form-group" ng-class="{'has-error' : baseErrors.signupMessage[0]}">
                  <label for="inputPassword3" class="col-sm-2 control-label">Signup Message</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="" ng-model="baseForm.signupMessage" placeholder="Signup Message">
                    <label class="control-label" for="inputWarning" ng-show="baseErrors.signupMessage[0]">
                    <i class="fa fa-bell-o"></i>@{{baseErrors.signupMessage[0]}}</label>
                  </div>
                </div>
                <div class="form-group" ng-class="{'has-error' : baseErrors.site_logo[0]}">
                  <label for="inputPassword3" class="col-sm-2 control-label">Site Logo</label>

                  <div class="col-sm-10">
                    <!-- <input type="text" class="form-control" id="" ng-model="baseForm.site_logo" placeholder="Site Logo"> -->
                    <input type="file" ngf-select ng-model="picFile" name="file"    
                           accept="image/*" ngf-max-size="2MB" required
                           ngf-model-invalid="errorFile"
                           ng-change="uploadPic(picFile)">
                      <i ng-show="myForm.file.$error.maxSize">File too large 
                        @{{errorFile.size / 1000000|number:1}}MB: max 2M</i>
                      <div class="progress progress-striped active" ng-show="picFile.progress >= 0 && !baseErrors.site_logo[0]">
                        <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="@{{picFile.progress}}" aria-valuemin="0" aria-valuemax="100" style="width:@{{picFile.progress}}%" 
                          ng-bind="picFile.progress + '%'">
                          <span class="sr-only">@{{picFile.progress}}% Completed</span>
                        </div>
                      </div>
                    <span ng-show="picFile.result">Upload Successful</span>
                    <label class="control-label" for="inputWarning" ng-show="baseErrors.site_logo[0]">
                    <i class="fa fa-bell-o"></i>@{{baseErrors.site_logo[0]}}</label>
                  </div>
                </div>
                <div class="form-group" >
                  <label for="inputPassword3" class="col-sm-2 control-label">Login/Signup Button Color</label>
                  <div class="col-sm-2">
                    <color-picker
                        ng-model="baseForm.loginButtonColor"
                        options="options"
                    ></color-picker>
                    <label class="control-label" for="inputWarning" ng-show="baseErrors.loginButtonColor[0]">
                    <i class="fa fa-bell-o"></i>@{{baseErrors.loginButtonColor[0]}}</label>
                  </div>
                  <label for="inputPassword3" class="col-sm-2 control-label">Configurator Link Color</label>
                  <div class="col-sm-2">
                    <color-picker
                        ng-model="baseForm.configuratorColor"
                        options="options"
                    ></color-picker>
                    <label class="control-label" for="inputWarning" ng-show="baseErrors.configuratorColor[0]">
                    <i class="fa fa-bell-o"></i>@{{baseErrors.configuratorColor[0]}}</label>
                  </div>
                  <label for="inputPassword3" class="col-sm-2 control-label">Configurator Active Link Color</label>
                  <div class="col-sm-2">
                    <color-picker
                        ng-model="baseForm.customPartColor"
                        options="options"
                    ></color-picker>
                    <label class="control-label" for="inputWarning" ng-show="baseErrors.customPartColor[0]">
                    <i class="fa fa-bell-o"></i>@{{baseErrors.customPartColor[0]}}</label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-12">
                    <div class="">
                      <div class="">
                        <h3 class="box-title">Markup List</h3>

                        <div class="">
                          <div class="input-group input-group-sm" style="width: 250px;">
                            <div class="input-group-btn">
                              <!-- <button type="submit" class="btn btn-primary">Add New</button> -->
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="table-responsive">
                        <table class="table table-bordered table-hover table-condensed">
                          <thead>
                            <tr>
                              <th>Domain</th>
                              <th>Fiber Markup</th>
                              <th>Mtp Markup</th>
                              <th>Cat Markup</th>
                              <th>Qutote Template</th>
                              <th>Attach CSV</th>
                              <th>Cost Alias</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                            <tr ng-repeat="markup in markupList">
                              <td>
                                <span editable-text="markup.domain" e-name="domain" e-form="markupform" onbeforesave="">
                                  @{{markup.domain || '' }}
                                </span>
                              </td>
                              <td>
                                <span editable-text="markup.fibermarkup" e-name="fibermarkup" e-form="markupform" onbeforesave="">
                                @{{markup.fibermarkup || ''}}
                                </span>
                              </td>
                              <td>
                                <span editable-text="markup.mtpMarkup" e-name="mtpMarkup" e-form="markupform" onbeforesave="" >
                                @{{markup.mtpMarkup || ''}}
                              </td>
                              <td>
                                <span editable-text="markup.catMarkup" e-name="catMarkup" e-form="markupform" onbeforesave="">
                                  @{{markup.catMarkup || ''}}
                                </span>
                              </td>
                              <td>

                                <span editable-select="markup.domainLevel" e-name="domainLevel" e-form="markupform" onbeforesave="" e-ng-options="s.value as s.text for s in templates">
                                  @{{markup.domainLevel || ''}}
                                </span>
                              </td>
                              <td>
                                <span editable-select="markup.attachCsvFlag" e-name="attachCsvFlag" e-form="markupform" onbeforesave="" e-ng-options="v.value as v.text for v in attachCv">
                                 @{{markup.attachCsvFlag || ''}}
                                </span>
                              </td>
                              <td>
                                <span editable-text="markup.costColunmName" e-name="costColunmName" e-form="markupform" onbeforesave="">
                                 @{{markup.costColunmName || ''}}
                                </span>
                              </td>
                              <td>
                                <!-- form -->
                                <form editable-form name="markupform" onbeforesave="" ng-show="markupform.$visible" class="form-buttons form-inline" shown="inserted == markup">
                                  <button type="button" ng-click="saveMarkup(markupform, markup)" ng-disabled="markupform.$waiting" class="btn  btn-primary">
                                    save
                                  </button>
                                  <button type="button" ng-disabled="markupform.$waiting" ng-click="markupform.$cancel()" class="btn btn-default">
                                    cancel
                                  </button>
                                </form>
                                <div class="buttons" ng-show="!markupform.$visible">
                                  <button type="button" class="btn btn-primary" ng-click="markupform.$show()">edit</button>
                                  <button type="button" class="btn btn-danger" ng-click="removeMarkup($index, markup)">del</button>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td colspan="8">
                                <div class="col-sm-1">
                                <button type="button" class="btn btn-default" ng-click="addMarkupRow()">Add row</button>
                              </div>
                              <div class="col-sm-11">
                                <div class="form-group has-error" ng-show="state.markupConfError"><label class="control-label" for=""><i class="fa fa-times-circle-o"></i> @{{state.markupConfError}}</label></div> 
                              </div>
                              </td>
                            </tr>
                          </tfoot>
                        </table>

                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                </div>

                <div class="form-group" ng-class="{'has-error': baseErrors.catPrefix || baseErrors.catSuffix}">
                  <label for="inputPassword3" class="col-sm-2 control-label">Price Formula</label>
                  <div class="col-sm-5">
                    <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                  </div>
                  <label class="col-sm-2 control-label">Cat Alias</label> 
                  <div class="col-sm-1">
                    <input type="text" placeholder="Prefix" ng-model="baseForm.catPrefix" class="form-control">
                  </div>
                  <div class="col-sm-1">
                      <input type="text" placeholder="Suffix" ng-model="baseForm.catSuffix" class="form-control">
                  </div>
                  <label class="control-label" for="inputWarning" ng-show="baseErrors.catPrefix || baseErrors.catSuffix">
                    <i class="fa fa-bell-o"></i>
                    Prefix and Suffix Fields are required
                  </label>
                </div>
            </div>
            
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="col-sm-1">
                  <button type="button" class="btn btn-primary" ng-click="saveBasicSettings()">Save</button>
                </div>
                <div class="col-sm-11">
                  <div class="form-group has-error" ng-show="state.basicSettingCheck"><label class="control-label" for=""><i class="fa fa-times-circle-o"></i> @{{state.basicSettingCheck}}</label></div> 
                </div>
            </div>
            </span>
          </div>
          <div class="box" ng-show="state.step == 2">
            <div class="box-header">
              <h3 class="box-title"><a href="#">Alias Settings</a>
              </h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 250px;">
                  <input type="text" ng-model="table_search" id="table_search" class="form-control pull-right" placeholder="Search" readonly="readonly">

                  <div class="input-group-btn">
                    <!-- <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button> -->
                    <button type="submit" class="btn btn-default btn-primary" ng-click="refreshForm('{{action('PortalsettingsController@loadForm')}}')">Add New</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <span class="form-horizontal">
            <div class="box-body table-responsive ">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Alias Type</label>

                  <div class="col-sm-4">
                    <select class="form-control" ng-model="search_prod" id='aliasCable' name='aliasCable' ng-init="search_prod = 151">
                      <option value="151" ng-selected="search_prod == 151">Fiber Jumper</option>
                      <option value="278">MTP</option>
                    </select>
                  </div>
                </div>
                <div class="table-responsive alias_list">
                  <table class="table table-hover">
                          <thead>
                            <tr>
                              <th>DB Ref.</th>
                              <th>Alias Part</th>
                              <th>Component</th>
                              <th>Alias Description</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr ng-repeat= "aliasRow in aliasList | filter:search_prod">
                              <td>
                                <span editable-text="aliasRow.dbRef"  e-name="dbRef" e-form="rowform" onbeforesave="" e-readonly>
                                    @{{ aliasRow.dbRef || 'empty' }}
                                </span>
                                </td>
                              <td>
                                <span editable-text="aliasRow.aliasPart"  e-name="aliasPart" e-form="rowform" onbeforesave="" e-required>
                                    @{{ aliasRow.aliasPart || 'empty' }}
                                </span>
                              </td>
                              <td>
                                <span editable-text="aliasRow.fieldTable" e-name="fieldTable" e-form="rowform" onbeforesave="" e-readonly>
                                    @{{ aliasRow.fieldTable || 'empty' }}
                                </span>
                                </td>
                              <td>
                                <span editable-text="aliasRow.aliasDescription" e-name="aliasDescription" e-form="rowform" onbeforesave="" e-required>
                                    @{{ aliasRow.aliasDescription || 'empty' }}
                                </span>
                              </td>
                              <td style="white-space: nowrap">
                                <!-- form -->
                                <form editable-form name="rowform" onbeforesave="" ng-show="rowform.$visible" class="form-buttons form-inline" shown="inserted == aliasRow">
                                  <button type="button" ng-click="saveCurrentAlias(rowform.$data, aliasRow,rowform)" ng-disabled="rowform.$waiting" class="btn  btn-primary">
                                    save
                                  </button>
                                  <button type="button" ng-disabled="rowform.$waiting" ng-click="rowform.$cancel()" class="btn btn-default">
                                    cancel
                                  </button>
                                </form>
                                <div class="buttons" ng-show="!rowform.$visible">
                                  <button type="button" class="btn btn-primary" ng-click="rowform.$show()">edit</button>
                                  <!-- <button type="button" class="btn btn-danger" ng-click="removeUser($index)">del</button> -->
                                </div>  
                              </td>
                            </tr>
                          </tbody>
                  </table>
                </div>
                <div class="form-group partnumberContainer" ng-show="search_prod == 151">
                    <label for="inputEmail3" class="col-sm-12 control-label text-left">Partnumber Formula</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" ng-model="aliasFormulaList.fiberPartPrefix" placeholder="Fiber Part Prefix">
                  </div>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" ng-model="aliasFormulaList.fiberPartString" placeholder="Fiber Part Formula">
                  </div>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" ng-model="aliasFormulaList.fiberPartSuffix" placeholder="Fiber Part Suffix">
                  </div>
                </div>
                <!-- Description Generator Fiber Jumper -->
                <div class="form-group partnumberContainer" ng-show="search_prod == 151">
                    <label for="inputEmail3" class="col-sm-12  control-label text-left">Description Formula</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" ng-model="aliasFormulaList.fiberDescPrefix" placeholder="Fiber Description Prefix">
                  </div>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" ng-model="aliasFormulaList.fiberDescString" placeholder="Fiber Description Formula">
                  </div>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" ng-model="aliasFormulaList.fiberDescSuffix" placeholder="Fiber Desc Suffix">
                  </div>
                </div>
                <div class="form-group partnumberContainer" ng-show="search_prod == 278">
                    <label for="inputEmail3" class="col-sm-12 control-label text-left">Partnumber Formula</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" ng-model="aliasFormulaList.mtpPartPrefix" placeholder="Prefix">
                  </div>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" ng-model="aliasFormulaList.mtpPartString" placeholder="Strands CorePart connectorA Connector B">
                  </div>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" ng-model="suffix" placeholder="aliasFormulaList.mtpPartSuffix">
                  </div>
                </div>
                <!-- Description Generator Fiber Jumper -->
                <div class="form-group partnumberContainer" ng-show="search_prod == 278">
                    <label for="inputEmail3" class="col-sm-12 control-label text-left">Description Formula</label>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" ng-model="aliasFormulaList.mtpDescPrefix" placeholder="Prefix">
                  </div>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" ng-model="aliasFormulaList.mtpDescString" placeholder="Strands CorePart connectorA Connector B">
                  </div>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" ng-model="aliasFormulaList.mtpDescSuffix" placeholder="Suffix">
                  </div>
                </div>

            </div>
            
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="button" class="btn btn-primary" ng-click="getPreviousState()">Back</button>
                <button type="button" class="btn btn-primary" ng-click="saveAliasSettings()">Next</button>
            </div>
            </span>
          </div>
          <div class="box" ng-show="state.step == 3">
            <div class="box-header">
              <h3 class="box-title"><a href="#">Quote Settings</a>
              </h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 250px;">
                  <input type="text" ng-model="table_search" id="table_search" class="form-control pull-right" placeholder="Search" readonly="readonly">

                  <div class="input-group-btn">
                    <!-- <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button> -->
                    <button type="submit" class="btn btn-default btn-primary" ng-click="refreshForm('{{action('PortalsettingsController@loadForm')}}')">Add New</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <form class="form-horizontal">
            <div class="box-body">
                <div class="form-group" ng-class="{'has-error' : quoteErrors.headerEmail[0]}">
                  <label for="inputEmail3" class="col-sm-2 control-label">Quotes Header Email</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" ng-model="quoteForm.headerEmail" placeholder="Quotes Header Email">
                    <label class="control-label" for="inputWarning" ng-show="quoteErrors.headerEmail[0]">
                    <i class="fa fa-bell-o"></i>@{{quoteErrors.headerEmail[0]}}</label>
                  </div>
                </div>
                <div class="form-group" ng-class="{'has-error' : quoteErrors.phone[0]}">
                  <label for="inputPassword3" class="col-sm-2 control-label">Phone</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="" ng-model="quoteForm.phone" placeholder="Phone">
                    <label class="control-label" for="inputWarning" ng-show="quoteErrors.phone[0]">
                    <i class="fa fa-bell-o"></i>@{{quoteErrors.phone[0]}}</label>
                  </div>
                </div>
                <div class="form-group" ng-class="{'has-error' : quoteErrors.message[0]}">
                  <label for="inputPassword3" class="col-sm-2 control-label">Contact Message</label>

                  <div class="col-sm-10" id="message_div">
                   <!-- <textarea class="form-control textarea" text-angular rows="5" placeholder="Contact Message" ng-model="$parent.quoteForm.message" id="message"></textarea> -->
                   <text-angular 
                      ng-model="quoteForm.message"
                    ></text-angular>
                   <label class="control-label" for="inputWarning" ng-show="quoteErrors.message[0]">
                    <i class="fa fa-bell-o"></i>@{{quoteErrors.message[0]}}</label>
                  </div>
                </div>
                
                <div class="form-group" ng-class="{'has-error' : quoteErrors.terms[0]}">
                  <label for="inputPassword3" class="col-sm-2 control-label">Quote Term Content</label>

                  <div class="col-sm-10">
                     <!-- <textarea class="form-control textarea" text-angular rows="5" placeholder="Contact Message" ng-model="quoteForm.terms" id="terms"></textarea> -->
                     <text-angular ng-model="quoteForm.terms"></text-angular>
                     <label class="control-label" for="inputWarning" ng-show="quoteErrors.terms[0]">
                    <i class="fa fa-bell-o"></i>@{{quoteErrors.terms[0]}}</label>
                  </div>
                </div>
                <div class="form-group" ng-class="{'has-error' : quoteErrors.quoteNumberPrefix[0]}">
                  <label for="inputPassword3" class="col-sm-2 control-label">Quote No. Prefix</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="" ng-model="quoteForm.quoteNumberPrefix" placeholder="Quote No. Prefix">
                    <label class="control-label" for="inputWarning" ng-show="quoteErrors.quoteNumberPrefix[0]">
                    <i class="fa fa-bell-o"></i>@{{quoteErrors.quoteNumberPrefix[0]}}</label>
                  </div>
                </div>
                <div class="form-group" ng-class="{'has-error' : quoteErrors.footerLeft[0]}">
                  <label for="inputPassword3" class="col-sm-2 control-label">Footer Left</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="" ng-model="quoteForm.footerLeft" placeholder="Footer Left">
                    <label class="control-label" for="inputWarning" ng-show="quoteErrors.footerLeft[0]">
                    <i class="fa fa-bell-o"></i>@{{quoteErrors.footerLeft[0]}}</label>
                  </div>
                </div>
                
                <div class="form-group" ng-class="{'has-error' : quoteErrors.footerMiddle[0]}">
                  <label for="inputPassword3" class="col-sm-2 control-label">Footer Middle</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="" ng-model="quoteForm.footerMiddle" placeholder="Footer Middle">
                    <label class="control-label" for="inputWarning" ng-show="quoteErrors.footerMiddle[0]">
                    <i class="fa fa-bell-o"></i>@{{quoteErrors.footerMiddle[0]}}</label>
                  </div>
                </div>

                <div class="form-group" ng-class="{'has-error' : quoteErrors.customPartColor[0]}">
                  <label for="inputPassword3" class="col-sm-2 control-label">Custom Part Prefix Color</label>
                  <div class="col-sm-10">
                    <color-picker
                        ng-model="quoteForm.customPartColor"
                        options="options"
                    ></color-picker>
                    <label class="control-label" for="inputWarning" ng-show="quoteErrors.customPartColor[0]">
                    <i class="fa fa-bell-o"></i>@{{quoteErrors.customPartColor[0]}}</label>
                  </div>
                </div>
            </div>
            
            <!-- /.box-body -->
            <div class="box-footer" ng-init="reloadCustomer({{isset($fkCustomerID) ? $fkCustomerID : false}})">
                <button type="button" class="btn btn-primary" ng-click="getPreviousState()">Back</button>
                <button type="button" class="btn btn-primary" ng-click="saveQuoteSettings()">Save</button>
            </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row (main row) -->
       </section>
@stop
@section('script_libraries')
<!-- pusher-js -->

<!-- Ckeditor -->
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<!-- pusher-angular -->
<script src="//cdn.jsdelivr.net/angular.pusher/latest/pusher-angular.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script src="{{asset('plugins/tinycolor/tinycolor-min.js')}}"></script>
<script src="{{asset('plugins/tinycolor/angularjs-color-picker.min.js')}}"></script>
<script src="{{asset('plugins/ng-file-upload/ng-file-upload-shim.min.js')}}"></script>
<script src="{{asset('plugins/ng-file-upload/ng-file-upload.min.js')}}"></script>
<script src="{{asset('plugins/angular-xeditable/js/xeditable.js')}}"></script>
<script src="{{asset('plugins/textAngular/textAngular-rangy.min.js')}}"></script>
<script src="{{asset('plugins/textAngular/textAngular-sanitize.min.js')}}"></script>
<script src="{{asset('plugins/textAngular/textAngular.min.js')}}"></script>
@stop

@section('header_script')
<script src="https://js.pusher.com/3.0/pusher.min.js"></script>
<script src="{{asset('Angular/portals/portal_markup.model.js')}}"></script>
<script src="{{asset('Angular/portals/portal_quote.model.js')}}"></script>
<script src="{{asset('Angular/company/companyModel.js')}}"></script>
<script src="{{asset('Angular/portals/save_portal.controller.js')}}"></script>
<script src="{{asset('Angular/portals/portals.model.js')}}"></script>
<script src="{{asset('Angular/portals/portal_colors.model.js')}}"></script>
<script src="{{asset('Angular/portals/portal_aliases.model.js')}}"></script>
<script type="text/javascript">
  
  $(function () {
    //bootstrap WYSIHTML5 - text editor
    // $(".textarea").wysihtml5();
    // angular.element(document.querySelector("#message_div")).scope().$apply();
  });

</script>
@stop