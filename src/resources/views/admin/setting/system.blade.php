@extends('admin.layouts.main')
@section('panel')
   <section>
       <div class="card">
           <div class="card-header">
               <h4 class="card-title">{{__($setTitle)}}</h4>
           </div>
           <div class="card-body">
               <ol class="list-group list-group-numbered">
                   @foreach(getArrayValue($applicationInfo, 'application') as $key => $filePath)
                       <li class="list-group-item d-flex justify-content-between align-items-start">
                           <div class="ms-2 me-auto text--dark">{{ replaceInputTitle($key) }}</div>
                           <span>{{ $filePath }}</span>
                       </li>
                   @endforeach

                   <li class="list-group-item d-flex justify-content-between align-items-start">
                       <div class="ms-2 me-auto text--dark">@lang('Document Root Folder') </div>
                       <span>{{ $server_detail['DOCUMENT_ROOT'] }}</span>
                   </li>
                   <li class="list-group-item d-flex justify-content-between align-items-start">
                       <div class="ms-2 me-auto text--dark">@lang('PHP Version')</div>
                       <span>{{ phpversion() }}</span>
                   </li>
                   <li class="list-group-item d-flex justify-content-between align-items-start">
                       <div class="ms-2 me-auto text--dark">@lang('Laravel Version')</div>
                       <span>{{ app()->version() }}</span>
                   </li>
                   <li class="list-group-item d-flex justify-content-between align-items-start">
                       <div class="ms-2 me-auto text--dark">@lang('IP Address')</div>
                       <span>{{ $server_detail['REMOTE_ADDR'] ?? ''}}</span>
                   </li>
                   <li class="list-group-item d-flex justify-content-between align-items-start">
                       <div class="ms-2 me-auto text--dark">@lang('Server Host')</div>
                       <span>{{ $server_detail['HTTP_HOST'] }}</span>
                   </li>
               </ol>
           </div>
       </div>

       <div class="card mt-3">
           <div class="card-header">
               <h4 class="card-title">{{ __('PHP Extension Access Management') }}</h4>
           </div>
           <div class="card-body">
               <ol class="list-group list-group-numbered">
                   @foreach(getArrayValue($applicationInfo, 'requirements.php') as $key => $filePath)
                       <li class="list-group-item d-flex justify-content-between align-items-start">
                           <div class="ms-2 me-auto text--dark">{{ $filePath }}</div>
                           <span>
                               <i class="las la-check text--success"></i>
                           </span>
                       </li>
                   @endforeach
               </ol>
           </div>
       </div>

       <div class="card mb-3 mt-3">
           <div class="card-header">
               <h6  class="card-title">{{ __('Access Control for Files and Folders') }}</h6>
           </div>
           <div class="responsive-table">
                <table>
                    <thead>
                        <tr>
                            <th>{{ __('Files and Folders') }}</th>
                            <th>{{ __('Permissions') }}</th>
                            <th>{{ __('Status') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach(getArrayValue($applicationInfo, 'permissions') as $key => $filePath)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $filePath }}</td>
                                <td>
                                    <i class="las la-check text--success"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
       </div>
   </section>
@endsection
