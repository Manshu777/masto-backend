@extends('adminmodule::layouts.master')

@section('title',translate('customer_list'))

@push('css_or_js')
    <link rel="stylesheet" href="{{asset('assets/admin-module')}}/plugins/dataTables/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="{{asset('assets/admin-module')}}/plugins/dataTables/select.dataTables.min.css"/>
@endpush

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-wrap d-flex justify-content-between flex-wrap align-items-center gap-3 mb-3">
                        <h2 class="page-title">{{translate('customer_list')}}</h2>
                        <!-- <div>
                            <a href="{{route('admin.customer.create')}}" class="btn btn--primary">
                                <span class="material-icons">add</span>
                                {{translate('add_customer')}}
                            </a>
                        </div> -->
                    </div>

                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center border-bottom mx-lg-4 mb-10 gap-3">
                        <ul class="nav nav--tabs">
                            <li class="nav-item">
                                <a class="nav-link {{$status=='all'?'active':''}}"
                                   href="{{url()->current()}}?status=all">
                                    {{translate('all')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{$status=='active'?'active':''}}"
                                   href="{{url()->current()}}?status=active">
                                    <!-- {{translate('active')}} -->
                                    Verified
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{$status=='inactive'?'active':''}}"
                                   href="{{url()->current()}}?status=inactive">
                                    <!-- {{translate('inactive')}} -->
                                    Not Verified
                                </a>
                            </li>
                        </ul>

                        <div class="d-flex gap-2 fw-medium">
                            <span class="opacity-75">{{translate('Total_Customers')}}:</span>
                            <span class="title-color">{{$customers->total()}}</span>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="all-tab-pane">
                            <div class="card">
                                <div class="card-body">
                                    <div class="data-table-top d-flex flex-wrap gap-10 justify-content-between">
                                        <form action="{{url()->current()}}?status={{$status}}"
                                              class="search-form search-form_style-two"
                                              method="POST">
                                            @csrf
                                            <div class="input-group search-form__input_group">
                                            <span class="search-form__icon">
                                                <span class="material-icons">search</span>
                                            </span>
                                                <input type="search" class="theme-input-style search-form__input"
                                                       value="{{$search}}" name="search"
                                                       placeholder="{{translate('search_here')}}">
                                            </div>
                                            <button type="submit"
                                                    class="btn btn--primary">{{translate('search')}}</button>
                                        </form>

                                        <!-- <div class="d-flex flex-wrap align-items-center gap-3">
                                            <div class="dropdown">
                                                <button type="button"
                                                        class="btn btn--secondary text-capitalize dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                    <span class="material-icons">file_download</span> download
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                                    <li>
                                                        <a class="dropdown-item"
                                                           href="{{env('APP_ENV') !='demo' ?route('admin.customer.download').'?search='.$search:'javascript:demo_mode()'}}">
                                                            {{translate('excel')}}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div> -->
                                    </div>

                                    <div class="table-responsive">
                                        <table id="example" class="table align-middle">
                                            <thead>
                                            <tr>
                                                <th>{{translate('Customer_Name')}}</th>
                                                <th class="text-center">{{translate('Contact_Info')}}</th>
                                                <th class="text-center">{{translate('Total_Bookings')}}</th>
                                                <th class="text-center">{{translate('Joined')}}</th>
                                                <!-- <th class="text-center">{{translate('status')}}</th> -->
                                                <th class="text-center">Document Verified</th>
                                                <th class="text-center">{{translate('action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($customers as $customer)
                                                <tr>
                                                    <td>
                                                        <a href="{{route('admin.customer.detail',[$customer->id, 'web_page'=>'overview'])}}">
                                                            {{$customer->first_name}} {{$customer->last_name}}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column align-items-center gap-1">
                                                            @if(env('APP_ENV')=='demo')
                                                                <label class="badge badge-primary">
                                                                    {{translate('protected')}}
                                                                </label>
                                                            @else
                                                                <a href="mailto:{{$customer->email}}"
                                                                   class="fz-12 fw-medium">
                                                                    {{$customer->email}}
                                                                </a>
                                                                <a href="tel:{{$customer->phone}}"
                                                                   class="fz-12 fw-medium">
                                                                    {{$customer->phone}}
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-center">{{$customer->bookings_count}}</td>
                                                    <td class="text-center">{{date('d M, Y',strtotime($customer->created_at))}}</td>
                                                    <td>
                                                        <!-- <label class="switcher mx-auto" data-bs-toggle="modal"
                                                               data-bs-target="#deactivateAlertModal">
                                                            <input class="switcher_input"
                                                                   onclick="route_alert('{{route('admin.customer.status-update',[$customer->id])}}','{{translate('want_to_update_status')}}')"
                                                                   type="checkbox" {{$customer->is_active?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label> -->
                                                        
                                                        
                                                        <!-- @if($customer->document != null)
                                                        <label class="switcher mx-auto" data-bs-toggle="modal"
                                                               data-bs-target="#deactivateAlertModal">
                                                            <input class="switcher_input"
                                                                   onclick="route_alert('{{route('admin.customer.status-update',[$customer->id])}}','{{translate('want_to_update_status')}}')"
                                                                   type="checkbox" {{$customer->document_status?'checked':''}}>
                                                            <span class="switcher_control"></span>
                                                        </label>
                                                        @else
                                                        <p class="text-center">
                                                        No document uploaded
                                                        </p>
                                                        @endif -->


                                                        @if($customer->document_status == "pending")
                                                        <div class="d-flex gap-2 justify-content-center">
                                                                    <!-- DENY -->
                                                                    <button type="button" class="btn btn--danger" data-bs-toggle="modal" data-bs-target="#denyModal-{{$customer->id}}">
                                                                        <span class="material-icons">block</span>{{translate('Deny')}}
                                                                    </button>
                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="denyModal-{{$customer->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-body">
                                                                                    <form action="{{route('admin.customer.status-update',[$customer->id, 'status'=>'rejected'])}}" method="POST">
                                                                                        @csrf
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                        <div class="text-center">
                                                                                            <img width="75" class="my-3" src="{{asset('assets/admin-module')}}/img/media/deny.png" alt="">
                                                                                            <h3 class="mb-3">{{translate('Deny_this_request')}}?</h3>
                                                                                        </div>

                                                                                        <div class="py-3 d-flex flex-wrap flex-md-nowrap gap-3 mb-2">
                                                                                            <!-- Customer Info -->
                                                                                            <div class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
                                                                                                <h4 class="mb-2">{{translate('Provider_Information')}}</h4>
                                                                                                
                                                                                            </div>
                                                                                            <!-- End Customer Info -->

                                                                                            
                                                                                        </div>

                                                                                        <textarea class="form-control h-140" placeholder="Note" name="note"></textarea>

                                                                                        <div class="mb-3 mt-4 d-flex justify-content-center gap-3">
                                                                                            <button type="button" class="btn btn--secondary" data-bs-dismiss="modal">{{translate('Cancel')}}</button>
                                                                                            <button type="submit" class="btn btn--primary">{{translate('Yes')}}</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Modal End -->


                                                                    <!-- Approve -->
                                                                    <button type="button" class="btn btn--success" data-bs-toggle="modal" data-bs-target="#approveModal-{{$customer->id}}">
                                                                        <span class="material-icons">done_outline</span>{{translate('Approve')}}
                                                                    </button>
                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="approveModal-{{$customer->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-lg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-body">
                                                                                    <form action="{{route('admin.customer.status-update',[$customer->id, 'status'=>'approved'])}}" method="POST">
                                                                                        @csrf
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                        <div class="text-center">
                                                                                            <img width="75" class="my-3" src="{{asset('assets/admin-module')}}/img/media/accept.png" alt="">
                                                                                            <h3 class="mb-3">{{translate('Accept_this_request')}}?</h3>
                                                                                        </div>

                                                                                        <div class="py-3 d-flex flex-wrap flex-md-nowrap gap-3 mb-2">
                                                                                            <!-- Customer Info -->
                                                                                            <div class="c1-light-bg radius-10 py-3 px-4 flex-grow-1">
                                                                                                <h4 class="mb-2">{{translate('Provider_Information')}}</h4>
                                                                                                
                                                                                            </div>
                                                                                            <!-- End Customer Info -->

                                                                                            
                                                                                        </div>

                                                                                        <textarea class="form-control h-140" placeholder="Note" name="note"></textarea>

                                                                                        <div class="mb-3 mt-4 d-flex justify-content-center gap-3">
                                                                                            <button type="button" class="btn btn--secondary" data-bs-dismiss="modal">{{translate('Cancel')}}</button>
                                                                                            <button type="submit" class="btn btn--primary">{{translate('Yes')}}</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Modal End -->
                                                        </div>
                                                        @elseif($customer->document_status == "approved")
                                                        <p class="text-center text-success">
                                                        Approved
                                                        </p>
                                                        
                                                        @elseif($customer->document_status == "rejected")
                                                        <p class="text-center">
                                                        Rejected
                                                        </p>
                                                        @else
                                                        <p class="text-center">
                                                        No document found
                                                        </p>
                                                        @endif
                                                    </td>


                                                    <td>
                                                        <div class="table-actions justify-content-center">
                                                            <!-- <a href="{{env('APP_ENV') !='demo' ?route('admin.customer.edit',[$customer->id]):'javascript:demo_mode()'}}"
                                                               class="table-actions_edit">
                                                                <span class="material-icons">edit</span>
                                                            </a> -->
                                                            <button type="button"
                                                                    onclick="form_alert('delete-{{$customer->id}}','{{translate('want_to_delete_this_customer')}}?')"
                                                                    class="table-actions_delete bg-transparent border-0 p-0">
                                                                <span class="material-icons">delete</span>
                                                            </button>
                                                            <a href="{{route('admin.customer.detail',[$customer->id, 'web_page'=>'overview'])}}"
                                                               class="table-actions_view">
                                                                <span class="material-icons">visibility</span>
                                                            </a>
                                                        </div>
                                                        <form
                                                            action="{{route('admin.customer.delete',[$customer->id])}}"
                                                            method="post" id="delete-{{$customer->id}}" class="hidden">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        {!! $customers->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('assets/admin-module')}}/plugins/select2/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.js-select').select2();
        });
    </script>
    <script src="{{asset('assets/admin-module')}}/plugins/dataTables/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets/admin-module')}}/plugins/dataTables/dataTables.select.min.js"></script>
@endpush
