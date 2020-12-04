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
                                <x-jet-input id="searchInput" class="block mt-1 w-50" type="text" name="searchInput" placeholder="Tìm kiếm" wire:model.lazy="keyWord" autofocus />
                                @if(Auth::user()->type == 1)
                                    @if($dataTableCustomerVisible == true)
                                    <x-jet-button wire:click="historyShowList"> {{ __('Lịch sử chỉnh sửa') }} </x-jet-button>
                                    @else
                                    <x-jet-button wire:click="customerShowList"> {{ __('Danh sach khach hang') }} </x-jet-button>
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
                                                    <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model.lazy.lazy="customerData.name" />
                                                    @error('customerData.name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                                <div class="col-md-6">
                                                    <x-jet-label for="cmnd" value="{{ __('Chứng minh nhân dân') }}" />
                                                    <x-jet-input id="cmnd" class="block mt-1 w-full" type="text" wire:model.lazy.lazy="customerData.cmnd" />
                                                    <br>
                                                    @error('customerData.cmnd')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <x-jet-label for="birthday" value="{{ __('Ngày sinh') }}" />
                                                    <x-jet-input id="birthday" class="block mt-1 w-full" type="date" wire:model.lazy.lazy="customerData.birthday" />
                                                    @error('customerData.birthday')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                                <div class="col-md-6">
                                                    <x-jet-label for="phone" value="{{ __('Số điện thoại') }}" />
                                                    <x-jet-input id="phone" class="block mt-1 w-full" type="text" wire:model.lazy.lazy="customerData.phone" />
                                                    @error('customerData.phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <x-jet-label for="household" value="{{ __('Hộ khẩu thường trú') }}" />
                                                    <x-jet-input id="household" class="block mt-1 w-full" type="text" wire:model.lazy.lazy="customerData.household" />
                                                    <br>
                                                    @error('customerData.household')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                                <div class="col-md-6">
                                                    <x-jet-label for="address" value="{{ __('Địa chỉ liên hệ') }}" />
                                                    <x-jet-input id="address" class="block mt-1 w-full" type="text" wire:model.lazy.lazy="customerData.address" />
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
                                                    <x-jet-label for="contract_no" value="{{ __('Mã hợp đồng') }}" />
                                                    <x-jet-input id="contract_no" class="block mt-1 w-full" type="text" wire:model.lazy.lazy="contractData.contract_no" />
                                                    @error('contractData.contract_no')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                                <div class="col-md-6">
                                                    <x-jet-label for="type" value="{{ __('Loại hợp dồng') }}" />
                                                    <x-jet-input id="type" class="block mt-1 w-full" type="text" wire:model.lazy.lazy="contractData.type" />
                                                    @error('contractData.type')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <x-jet-label for="lot_number" value="{{ __('Mã lô') }}" />
                                                    <x-jet-input id="lot_number" class="block mt-1 w-full" type="text" wire:model.lazy.lazy="contractData.lot_number" />
                                                    @error('contractData.lot_number')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @endError
                                                </div>
                                                <div class="col-md-6">
                                                    <x-jet-label for="area_signed" value="{{ __('Diện tích ký') }}" />
                                                    <x-jet-input id="area_signed" class="block mt-1 w-full" type="text" wire:model.lazy.lazy="contractData.area_signed" />
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
                                                        <select class="custom-select" wire:model.lazy.lazy="contractData.status">
                                                            @foreach ($this->contractStatus as $status)
                                                                <option value="{{$loop->index}}">{{ $status }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @if($contractData['status'] != 2)
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="inputGroupSelect01">Giữ chỗ</label>
                                                        </div>
                                                        <select class="custom-select" wire:model.lazy.lazy="contractData.status_created_by">
                                                            @foreach($this->contractStatusCreated as $item)
                                                                <option value="{{$loop->index}}">{{$item}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <x-jet-label for="signed_date" value="{{ __('Ngày ký') }}" />
                                                    <x-jet-input type="date" class="block mt-1 w-full" wire:model.lazy.lazy="contractData.signed_date" id="signed_date"/>
                                                </div>
                                                <div class="col-md-6">
                                                    <x-jet-label for="signed_date" value="{{ __('Giá bán') }}" />
                                                    <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy.lazy="contractData.value" id="value"/>
                                                </div>

                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <x-jet-label for="payment_progress" value="{{ __('Tiến độ thanh toán') }}" />
                                                    <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy.lazy="paymentData.payment_progress" id="payment_progress"/>
                                                </div>
                                                <div class="col-md-6">
                                                    <x-jet-label for="payment_date_95" value="{{ __('Ngày thanh toán đủ 95%') }}" />
                                                    <x-jet-input type="date" class="block mt-1 w-full" wire:model.lazy.lazy="paymentData.payment_date_95" id="payment_date_95"/>
                                                </div>

                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="inputGroupSelect01">Dự án</label>
                                                        </div>
                                                        <select class="custom-select" wire:model.lazy.lazy="contractData.project_id">
                                                            <option value="0" selected>Chọn dự án</option>
                                                            @foreach($projects as $project)
                                                                <option value="{{$project->id}}">{{$project->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 flex">
                                                    <x-jet-label for="signed" value="{{ __('Đã ký / chưa ký') }}" />
                                                    <input id="signed" type="checkbox" wire:model.lazy.lazy="contractData.signed" class="form-checkbox h-5 w-5 text-green-500 ml-2">
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
                                        <select class="custom-select" wire:model.lazy.lazy="selectStatus">
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
                                        <select class="custom-select" wire:model.lazy.lazy="selectBill">
                                            <option value="0">Đúng hạn</option>
                                            <option value="1">Trễ hạn</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Từ</label>
                                        </div>
                                        <select class="custom-select" wire:model.lazy.lazy="selectTimeFrom">
                                            @foreach($contractTime as $time)
                                                    <option>{{Carbon\Carbon::parse($time->created_at)->format('d/m/Y')}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Đến</label>
                                        </div>
                                        <select class="custom-select" wire:model.lazy.lazy="selectTimeTo">
                                            @foreach($contractTime as $time)
                                                <option>{{Carbon\Carbon::parse($time->created_at)->format('d/m/Y')}}</option>
                                            @endforeach
                                        </select>
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
                                            <th>Actions</th>
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
                                                    <td>{{Carbon\Carbon::parse((App\Models\Juridical::where('contract_id', $customer->contractID)->firstOrFail())->delivery_book_date)->format('d/m/Y')}}</td>
                                                @else
                                                    <td></td>
                                                @endif

                                                <td>
                                                @if(Auth::user()->type != 3)
                                                    <x-jet-button class="ml-2" wire:click="updateShowModal({{ $customer->customerID }},{{$customer->contractID}})"> {{ __('Sửa') }} </x-jet-button>
                                                    <x-jet-button class="ml-2" wire:click="confirmDelete({{$customer->contractID}})"> {{ __('Xóa') }} </x-jet-button>
                                                @endif
                                                </td>
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
                                        <th>ID</th>
                                        <th>Tiêu đề</th>
                                        <th>Thời gian chỉnh sửa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($histories as $history)
                                    <tr>
                                        <td><a href="{{route('customerDetail', $history->customer_id)}}">{{$history->customer_id}}</a></td>
                                        <td>{{$history->title}}</td>
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

<!-- Confirm delete customer modal -->

