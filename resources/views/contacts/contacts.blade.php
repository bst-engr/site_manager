@extends("layouts.default")

@section('header_styles')
  <link rel="stylesheet" href="{{asset('dist/css/skins/_all-skins.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
@stop

@section('content')
<!-- Small boxes (Stat box) -->
<section class="content" ng-app="contactsApp" ng-controller="contactsController" ng-cloak >
      
      <!-- Main row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Available Contacts</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody>
                  <tr>
                    <th>Contact ID</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Avatar</th>
                    <th>Added On</th>
                    <th>Action</th>
                  </tr>
                  <tr ng-repeat="contact in contacts">
                    <td>{[{ contact.contact_id }]}</td>
                    <td>{[{ contact.user_id }]}</td>
                    <td>{[{ contact.name }]}</td>
                    <td>{[{ contact.email }]}</td>
                    <td>{[{ contact.phone_number }]}</td>
                    <td>{[{ contact.avatar }]}</td>
                    <td>{[{ contact.added_on }]}</td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" ng-click="deleteRecord(contact.id)"><i class="fa fa-trash-o"></i></button>
                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal" ng-click="editRecord(contact)"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-default btn-sm" ng-click="viewRecord(contact.id)"><i class="fa fa-file"></i></button>
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
      <!-- Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" placeholder="Email" ng-model="contactForm.email">
                  </div>
                </div>
                <div class="form-group">
                  <label for="user_id" class="col-sm-2 control-label">User Id</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="user_id" placeholder="User Id" ng-model="contactForm.user_id">
                  </div>
                </div>
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10">
                       <input type="text" class="form-control" id="name" placeholder="Name" ng-model="contactForm.name" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="phone_number" class="col-sm-2 control-label">Phone Number</label>
                  <div class="col-sm-10">
                       <input type="text" class="form-control" id="phone_number" placeholder="Phone Number" ng-model="contactForm.phone_number" />
                       <input type="hidden" id="contact_id" ng-model="contactForm.contact_id" />
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <!-- /.box-footer -->
            </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" ng-click="saveContactChanges()">Save changes</button>
            </div>
          </div>
        </div>
      </div>
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
<script src="{{asset('Angular/contacts/contacts.controller.js')}}"></script>
<script src="{{asset('Angular/contacts/contacts.model.js')}}"></script>
@stop