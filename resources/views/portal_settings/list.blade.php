@extends("layouts.default")

@section('header_styles')
  <link rel="stylesheet" href="{{asset('dist/css/skins/_all-skins.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
@stop
@section('page_title')
Site Manager
@stop

@section('page_sub_title')
Whitelabel Portal Settings
@stop

@section('content')
<!-- Small boxes (Stat box) -->
<section class="content" ng-app="portalsApp" ng-controller="portalsController" ng-cloak >
      
      <!-- Main row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><a href="#">Available Subscribers</a>
              </h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 250px;">
                  <input type="text" name="table_search" ng-model="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default btn-primary" onclick="window.location= '{{action('PortalsettingsController@loadForm')}}'">Add New</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <div class="alert alert-danger alert-dismissible alert-box" ng-hide="!state.pusherNotification">
                <button type="button" class="close" aria-hidden="true" ng-click="state.pusherNotification=false">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <span class="data-container">@{{state.pusherNotification}}.</span>
              </div>
              <table class="table table-hover">
                <tbody>
                  <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Site Name</th>
                    <th>Site URL</th>
                    <th>Action</th>
                  </tr>
                  <tr ng-repeat="customer in customers | filter:table_search">
                    <td>@{{ customer.fkCustomerID }}</td>
                    <td>@{{ customer.companyName }}</td>
                    <td>@{{ customer.site_name }}</td>
                    <td>@{{ customer.site_url }}</td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-md" ng-click="deletePortal(customer.id)"><i class="fa fa-trash-o"></i></button>
                        <button type="button" class="btn btn-default btn-md" ng-click="editCustomer(customer.fkCustomerID)"><i class="fa fa-edit"></i></button><!-- 
                        <button type="button" class="btn btn-default btn-sm" ng-click="viewRecord(contact.id)"><i class="fa fa-file"></i></button> -->
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row (main row) -->
       </section>
@stop
@section('script_libraries')
<!-- pusher-js -->
<script src="//js.pusher.com/2.2/pusher.min.js"></script>

<!-- pusher-angular -->
<script src="//cdn.jsdelivr.net/angular.pusher/latest/pusher-angular.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>

@stop

@section('header_script')
<script src="https://js.pusher.com/3.0/pusher.min.js"></script>
<script src="{{asset('Angular/portals/portals.controller.js')}}"></script>
<script src="{{asset('Angular/portals/portals.model.js')}}"></script>
<script src="{{asset('Angular/portals/portal_markup.model.js')}}"></script>
<script src="{{asset('Angular/portals/portal_quote.model.js')}}"></script>
<script src="{{asset('Angular/company/companyModel.js')}}"></script>
@stop