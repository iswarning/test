<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Quản lý khách hàng
    </h2>
</x-slot>
<div>
    <section>

        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Danh sách khách hàng</h3>
                        </div>
                        <div class="card-body">
                            <div>
                                @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                                @endif
                            </div>
                            <div class="flex items-center justify-between mt-1 w-full">
                                <x-jet-input autocomplete="off" id="searchInput" class="block mt-1 w-50" type="text" name="searchInput" placeholder="Tìm kiếm" wire:model="keyWord" autofocus />
                                @if(Auth::user()->type == 1)
                                    @if($dataTableCustomerVisible == true)
                                    <x-jet-button wire:click="historyShowList"> {{ __('Lịch sử chỉnh sửa') }} </x-jet-button>
                                    @else
                                    <x-jet-button wire:click="customerShowList"> {{ __('Danh sách khách hàng') }} </x-jet-button>
                                    @endif
                                @endif
                                @if(Auth::user()->type == 1 or Auth::user()->type == 2)
                                    <x-jet-button wire:click="createShowModal"> {{ __('Thêm khách hàng') }} </x-jet-button>
                                @endif
                                <!-- Create and update customer modal -->

                                <x-jet-dialog-modal wire:model.lazy="modalFormCustomerVisible">
                                        <x-slot name="title">
                                            {{ __('Thêm khách hàng') }}
                                        </x-slot>

                                        <x-slot name="content">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-jet-label for="name" value="{{ __('Họ tên') }}" />
                                                    <x-jet-input autocomplete="off" id="name" class="block mt-1 w-full" type="text" wire:model.lazy="customerData.name" />
                                                    @error('customerData.name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                                <div class="col-md-6">
                                                    <x-jet-label for="cmnd" value="{{ __('Chứng minh nhân dân') }}" />
                                                    <x-jet-input autocomplete="off" id="cmnd" class="block mt-1 w-full" type="number" wire:model.lazy="customerData.cmnd" />
                                                    <br>
                                                    @error('customerData.cmnd')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <x-jet-label for="birthday" value="{{ __('Ngày sinh') }}" />
                                                    <x-jet-input autocomplete="off" type="text" id="birthday" class="block mt-1 w-full datepicker" placeholder="Chọn ngày sinh.." wire:model="customerData.birthday" />
                                                    @error('customerData.birthday')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                                <div class="col-md-6">
                                                    <x-jet-label for="phone" value="{{ __('Số điện thoại') }}" />
                                                    <x-jet-input autocomplete="off" id="phone" class="block mt-1 w-full" type="number" wire:model.lazy="customerData.phone" />
                                                    @error('customerData.phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <x-jet-label for="household" value="{{ __('Hộ khẩu thường trú') }}" />
                                                    <x-jet-input autocomplete="off" id="household" class="block mt-1 w-full" type="text" wire:model.lazy="customerData.household" />
                                                    <br>
                                                    @error('customerData.household')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                                <div class="col-md-6">
                                                    <x-jet-label for="address" value="{{ __('Địa chỉ liên hệ') }}" />
                                                    <x-jet-input autocomplete="off" id="address" class="block mt-1 w-full" type="text" wire:model.lazy="customerData.address" />
                                                    <br>
                                                    @error('customerData.address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                            </div>
                                        </x-slot>

                                        <x-slot name="footer">
                                            <x-jet-secondary-button wire:click="$toggle('modalFormCustomerVisible')" wire:loading.attr="disabled">
                                                {{ __('Hủy') }}
                                            </x-jet-secondary-button>

                                                <x-jet-button class="ml-2" wire:click="nextModal" wire:loading.attr="disabled">
                                                    {{ __('Tiếp theo') }}
                                                </x-jet-button>

                                        </x-slot>
                                </x-jet-dialog-modal>


                                <x-jet-dialog-modal wire:model.lazy="modalFormContractVisible">
                                    <div wire:model.lazy="modalFormCustomerVisible">
                                        <x-slot name="title">
                                            {{ __('Thêm hợp đồng') }}
                                        </x-slot>

                                        <x-slot name="content">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-jet-label for="contract_no" value="{{ __('Số hợp đồng') }}" />
                                                    <x-jet-input autocomplete="off" id="contract_no" class="block mt-1 w-full" type="text" wire:model.lazy="contractData.contract_no" />
                                                    @error('contractData.contract_no')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                                <div class="col-md-6">
                                                    <x-jet-label for="type" value="{{ __('Loại hợp đồng') }}" />
                                                    <x-jet-input autocomplete="off" id="type" class="block mt-1 w-full" type="text" wire:model.lazy="contractData.type" />
                                                    @error('contractData.type')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <x-jet-label for="lot_number" value="{{ __('Mã lô') }}" />
                                                    <x-jet-input autocomplete="off" id="lot_number" class="block mt-1 w-full" type="text" wire:model.lazy="contractData.lot_number" />
                                                    @error('contractData.lot_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                                <div class="col-md-6">
                                                    <x-jet-label for="area_signed" value="{{ __('Diện tích ký') }}" />
                                                    <x-jet-input autocomplete="off" id="area_signed" class="block mt-1 w-full" type="number" wire:model.lazy="contractData.area_signed" />
                                                    @error('contractData.area_signed')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="inputGroupSelect01">Trạng thái</label>
                                                        </div>
                                                        <select class="custom-select" wire:model.lazy="contractData.status">
                                                            <option>Chọn trạng thái</option>
                                                            @foreach ($this->contractStatus as $status)
                                                                <option value="{{$loop->index}}">{{ $status }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('contractData.status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                                @if($contractData['status'] != 2)
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="inputGroupSelect01">Giữ chỗ</label>
                                                        </div>
                                                        <select class="custom-select" wire:model.lazy="contractData.status_created_by">
                                                            <option>Chọn giữ chỗ</option>
                                                            @foreach($this->contractStatusCreated as $item)
                                                                <option value="{{$loop->index}}">{{$item}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('contractData.status_created_by')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-jet-label for="signed_date" value="{{ __('Ngày ký') }}" />
                                                    <x-jet-input autocomplete="off" type="text" id="signed_date" class="block mt-1 w-full" wire:model="contractData.signed_date" placeholder="Chọn ngày ký.."/>
                                                    @error('contractData.signed_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                                <div class="col-md-6">
                                                    <x-jet-label for="value" value="{{ __('Giá bán') }}" />
                                                    <x-jet-input autocomplete="off" type="text" class="block mt-1 w-full" wire:model.lazy="contractData.value" id="value"/>
                                                    @error('contractData.value')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>

                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <x-jet-label for="payment_progress" value="{{ __('Tiến độ thanh toán') }}" />
                                                    <x-jet-input autocomplete="off" type="text" class="block mt-1 w-full" wire:model.lazy="paymentData.payment_progress" id="payment_progress"/>
                                                    @error('paymentData.payment_progress')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                                <div class="col-md-6">
                                                    <x-jet-label for="payment_date_95" value="{{ __('Ngày thanh toán đủ 95%') }}" />
                                                    <x-jet-input autocomplete="off" type="text" id="payment_date_95" class="block mt-1 w-full datepicker" placeholder="Chọn ngày thanh toán.."/>

                                                </div>

                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="inputGroupSelect01">Dự án</label>
                                                        </div>
                                                        <select class="custom-select" wire:model.lazy="contractData.project_id">
                                                            <option value="0">Chọn dự án</option>
                                                            @foreach($projects as $project)
                                                                <option value="{{$project->id}}">{{$project->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('contractData.project_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>

                                                <div class="col-md-6 flex">
                                                    <x-jet-label for="signed" value="{{ __('Đã ký / chưa ký') }}" />
                                                    <input id="signed" type="checkbox" wire:model.lazy="contractData.signed" class="form-checkbox h-5 w-5 text-green-500 ml-2">
                                                    @error('contractData.signed')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                            </div>
                                        </x-slot>

                                        <x-slot name="footer">
                                            <x-jet-secondary-button wire:click="$toggle('modalFormContractVisible')" wire:loading.attr="disabled">
                                                {{ __('Hủy') }}
                                            </x-jet-secondary-button>
                                            <x-jet-button class="ml-2" wire:click="backModal" wire:loading.attr="disabled">
                                                {{ __('Quay lại') }}
                                            </x-jet-button>

                                            @if ($customerId)
                                            <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                                                {{ __('Cập nhật') }}
                                            </x-jet-button>
                                            @else
                                            <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                                                {{ __('Lưu') }}
                                            </x-jet-button>
                                            @endif



                                        </x-slot>
                                    </div>
                                </x-jet-dialog-modal>


                            </div>
                            <br>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Trạng thái</label>
                                        </div>
                                        <select class="custom-select" wire:model.lazy="selectStatus">
                                            <option>Chọn trạng thái</option>
                                            @foreach ($this->contractStatus as $status)
                                                <option value="{{$loop->index}}">{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Thanh toán</label>
                                        </div>
                                        <select class="custom-select" wire:model.lazy="selectBill">
                                            <option>Chọn thanh toán</option>
                                            <option value="0">Đúng hạn</option>
                                            <option value="1">Trễ hạn</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <x-jet-input autocomplete="off" type="text" id="daterangepicker" class='w-full' placeholder="Chọn ngày..."/>
                                    
                                </div> --}}
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Từ</label>
                                            <x-jet-input autocomplete="off" type="text" id="selectTimeFrom" class='w-52' placeholder="Chọn ngày..." wire:model="selectTimeFrom"/>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Đến</label>
                                            <x-jet-input autocomplete="off" type="text" id="selectTimeTo" class='w-52' placeholder="Chọn ngày..." wire:model="selectTimeTo"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Data Table Customer -->
                            @if($this->dataTableCustomerVisible == true)
                                <table class="table table-striped" wire:model.lazy="dataTableCustomerVisible">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên</th>
                                            <th>CMND</th>
                                            <th>Dự Án</th>
                                            <th>Mã Lô</th>
                                            <th>Tình trạng</th>
                                            <th>Tiến độ</th>
                                            <th>Ngày bàn giao</th>
                                            <th class="text-center">Sửa</th>
                                            <th class="text-center">Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @foreach ($customers as $customer)
                                            @if($customer->contractStatus == 2 && Auth::user()->type == 3)

                                                @else
                                            <tr>
                                                <td>{{$customer->customerID}}</td>
                                                <td>
                                                    <a class="text-indigo-600 hover:text-indigo-900" href="{{ URL::to('/customer/'.$customer->customerID)}}">
                                                        {{ $customer->customerName }}
                                                    </a>
                                                </td>
                                                <td>{{$customer->cmnd}}</td>
                                                <td>{{$customer->projectName}}</td>
                                                <td>{{$customer->lot_number}}</td>
                                                <td>{{$this->contractStatus[$customer->contractStatus]}}</td>
                                                <td>{{$customer->payment_progress}}</td>

                                                @if(App\Models\Juridical::where('contract_id', $customer->contractID)->first() != null)
                                                    <td>{{(App\Models\Juridical::where('contract_id', $customer->contractID)->first())->delivery_book_date}}</td>
                                                @else
                                                    <td></td>
                                                @endif


                                                @if(Auth::user()->type != 3)
                                                    <td><x-jet-button class="ml-2" wire:click="updateShowModal({{ $customer->customerID }},{{$customer->contractID}})"> {{ __('Sửa') }} </x-jet-button></td>
                                                    <td><x-jet-button class="ml-2" wire:click="confirmDelete({{$customer->contractID}})"> {{ __('Xóa') }} </x-jet-button></td>
                                                @endif

                                            </tr>
                                            @endif

                                        @endforeach
                                    </tbody>
                                </table>

                            <x-jet-confirmation-modal wire:model.lazy="modalConfirmDeleteVisible">
                                <x-slot name="title">
                                    {{ __('Xóa thông tin khách hàng') }}
                                </x-slot>

                                <x-slot name="content">
                                    {{ __('Bạn có chắc muốn xóa thông tin khách hàng này?') }}
                                </x-slot>

                                <x-slot name="footer">
                                    <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                                        {{ __('Hủy') }}
                                    </x-jet-secondary-button>

                                    <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                                        {{ __('Xóa') }}
                                    </x-jet-danger-button>
                                </x-slot>
                            </x-jet-confirmation-modal>

                               {{ $customers->links() }}
                            @else

                            <!-- Data Table History -->

                            <table class="table table-striped" wire:model.lazy="dataTableHistoryVisible">
                                <thead>
                                    <tr>
                                        <th>Tiêu đề</th>
                                        <th>Thời gian chỉnh sửa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($histories as $history)
                                    <tr>
                                        <td>{{$history->title}} của <a href="{{route('customerDetail', $history->customer_id)}}"> khách hàng {{$history->customer_id}}</a> </td>
                                        <td>{{Carbon\Carbon::parse($history->created_at)->format('d/m/Y H:i:s')}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $histories->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>

        $('#birthday').datepicker({ 
            yearRange: "-100:+0" ,
        });
        $('#birthday').on('change',function(e){
           @this.set('customerData.birthday', e.target.value);
        });

        $('#signed_date').datepicker();
        $('#signed_date').on('change',function(e){
            @this.set('contractData.signed_date', e.target.value);
        });

        $('#payment_date_95').datepicker();
        $('#payment_date_95').on('change',function(e){
            @this.set('paymentData.payment_date_95', e.target.value);
        });

        // $('#daterangepicker').val() = '';
        // $(function() {
        //     $('#daterangepicker').daterangepicker({
        //         timePicker: true,
        //         locale: {
        //             format: 'YYYY-MM-DD HH:mm:ss'
        //         },
        //     });
        // });
        // $('#daterangepicker').on('apply.daterangepicker', function(ev, picker) {
        //     console.log(picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
        //     console.log(picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
        //     // @this.set('selectTimeFrom', picker.startDate.format('YYYY-MM-DD HH:mm:ss'));
        //     // @this.set('selectTimeTo', picker.endDate.format('YYYY-MM-DD HH:mm:ss'));
        // });
        
        $('#selectTimeFrom').datepicker();
        $('#selectTimeFrom').on('change',function(e){
           @this.set('selectTimeFrom', e.target.value);
        });

        $('#selectTimeTo').datepicker();
        $('#selectTimeTo').on('change',function(e){
            @this.set('selectTimeTo', e.target.value);
        });


    ( function( factory ) {
            if ( typeof define === "function" && define.amd ) {

                // AMD. Register as an anonymous module.
                define( [ "../widgets/datepicker" ], factory );
            } else {

                // Browser globals
                factory( jQuery.datepicker );
            }
        }( function( datepicker ) {
            // var d = new Date().getFullYear();

            datepicker.regional.vi = {
                changeYear: true,
                changeMonth: true,
                yearRange: '+0:+2',
                closeText: "Đóng",
                prevText: "&#x3C;Trước",
                nextText: "Tiếp&#x3E;",
                currentText: "Hôm nay",
                monthNames: [ "Tháng Một", "Tháng Hai", "Tháng Ba", "Tháng Tư", "Tháng Năm", "Tháng Sáu",
                "Tháng Bảy", "Tháng Tám", "Tháng Chín", "Tháng Mười", "Tháng Mười Một", "Tháng Mười Hai" ],
                monthNamesShort: [ "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12" ],
                dayNames: [ "Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy" ],
                dayNamesShort: [ "CN", "T2", "T3", "T4", "T5", "T6", "T7" ],
                dayNamesMin: [ "CN", "T2", "T3", "T4", "T5", "T6", "T7" ],
                weekHeader: "Tu",
                dateFormat: "yy-mm-dd",
                firstDay: 0,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: "" ,
                // showOn: "both",
                // buttonImageOnly: true,
                // buttonImage: "calendar.gif",
                // buttonText: "Calendar"
            };
            datepicker.setDefaults( datepicker.regional.vi );

            return datepicker.regional.vi;

        } ) );
</script>
<!-- Confirm delete customer modal -->

