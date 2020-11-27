<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Quản lý khách hàng
    </h2>
</x-slot>
<div>
    <section>
    <div class="container">
        <br>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ $tab == 'customer' ? 'active' : '' }}" wire:click="$set('tab', 'customer')" href="#">Thong Tin</a>
            </li>
            @foreach($contract as $key => $item)
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'contract'.$key.'' ? 'active' : '' }}" wire:click="tabChange('contract{{$key}}', {{$item->id}})" href="#">Hop Dong {{$key}}</a>
                </li>
            @endforeach
        </ul>
        @if($tab == 'customer') 
            <div class="tab-pane container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            <h3>Thông tin cơ bản của khách hàng</h3>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Họ và Tên: </td>
                                            <td>{{$this->customerData->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>CMND: </td>
                                            <td>{{$this->customerData->id}}</td>
                                        </tr>
                                        <tr>
                                            <td>Địa Chỉ: </td>
                                            <td>{{$this->customerData->address}}</td>
                                        </tr>
                                        <tr>
                                            <td>Ngày Sinh: </td>
                                            <td>{{$this->customerData->birthday}}</td>
                                        </tr>
                                        <tr>
                                            <td>Hộ Khẩu: </td>
                                            <td>{{$this->customerData->household}}</td>
                                        </tr>
                                        <tr>
                                            <td>Số điện thoại: </td>
                                            <td>{{$this->customerData->phone}}</td>
                                        </tr>                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @foreach($contract as $key => $row)
            @if($tab == 'contract'.$key.'')
                <div class="tab-pane container">

                    {{-- Hợp đồng --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                <h3>Thông tin hợp đồng</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Mã lô giữ chỗ: </td>
                                                <td>{{$row->lot_number}}</td>
                                            </tr>
                                            <tr>
                                                <td>Trạng thái: </td>
                                                <td>
                                                    {{$contractStatus[$row->status]}}
                                                    @if($contractStatus[$row->status] === "Trả giữ chỗ" or $$contractStatus[$row->status] === "Bỏ giữ chỗ")
                                                        {{$row->status_created_by}}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Đã ký/ chưa ký: </td>
                                                <td>@if($row->signed != 0) Đã ký @else Chưa ký @endif</td>
                                            </tr>
                                            <tr>
                                                <td>Ngày ký: </td>
                                                <td>{{$row->signed_date}}</td>
                                            </tr>
                                            <tr>
                                                <td>Loại hợp đồng: </td>
                                                <td>{{$row->type}}</td>
                                            </tr>
                                            <tr>
                                                <td>Số hợp đồng: </td>
                                                <td>{{$row->contract_no}}</td>
                                            </tr>
                                            <tr>
                                                <td>Diện tích ký: </td>
                                                <td>{{$row->area_signed}}</td>
                                            </tr>
                                            <tr>
                                                <td>Giá bán: </td>
                                                <td>{{number_format($row->value)}}</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><x-jet-button wire:click="updateShowContract({{$row->id}})"> Sửa </x-jet-button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                                                       
                        </div>
                    </div><p></p>
                    
                    <x-jet-dialog-modal wire:model="modalShowContractVisible">
                            <x-slot name="title">
                                {{ __('Sua hợp đồng') }}
                            </x-slot>

                            <x-slot name="content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-jet-label for="contract_no" value="{{ __('Mã hợp đồng') }}" />
                                        <x-jet-input id="contract_no" class="block mt-1 w-full" type="text" wire:model="contractData.contract_no" />
                                        @error('contractData.contract_no')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="type" value="{{ __('Loại hợp dồng') }}" />
                                        <x-jet-input id="type" class="block mt-1 w-full" type="text" wire:model="contractData.type" />
                                        @error('contractData.type')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="lot_number" value="{{ __('Mã lô') }}" />
                                        <x-jet-input id="lot_number" class="block mt-1 w-full" type="text" wire:model="contractData.lot_number" />
                                        @error('contractData.lot_number')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="area_signed" value="{{ __('Diện tích ký') }}" />
                                        <x-jet-input id="area_signed" class="block mt-1 w-full" type="text" wire:model="contractData.area_signed" />
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
                                            <select class="custom-select" wire:model="contractData.status">                                                       
                                                @foreach ($this->contractStatus as $status)
                                                    <option value="{{$loop->index}}">{{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('contractData.status')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Dự án</label>
                                            </div>
                                            <select class="custom-select" wire:model="contractData.project_id">
                                                <option value="0" selected>Chọn dự án</option>
                                                @foreach($this->projectData as $project)
                                                    <option value="{{$project->id}}">{{$project->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('contractData.project_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-jet-label for="signed_date" value="{{ __('Ngày ký') }}" />
                                        <x-jet-input type="date" wire:model="contractData.signed_date" id="signed_date"/>
                                        @error('contractData.signed_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="signed_date" value="{{ __('Giá bán') }}" />
                                        <x-jet-input type="text" wire:model="contractData.value" id="value"/>
                                        @error('contractData.value')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="payment_date_95" value="{{ __('Ngày thanh toán đủ 95%') }}" />
                                        <x-jet-input type="date" wire:model="paymentData.payment_date_95" id="payment_date_95"/>
                                        @error('paymentData.payment_date_95')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="payment_progress" value="{{ __('Tiến độ thanh toán') }}" />
                                        <x-jet-input type="text" wire:model="paymentData.payment_progress" id="payment_progress"/>
                                        @error('paymentData.payment_progress')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6 flex">
                                        <x-jet-label for="signed" value="{{ __('Đã ký / chưa ký') }}" />
                                        <input id="signed" type="checkbox" wire:model="contractData.signed" class="form-checkbox h-5 w-5 text-green-500 ml-2">
                                        @error('contractData.signed')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                            </x-slot>
                        
                            <x-slot name="footer">
                                <x-jet-secondary-button wire:click="$toggle('modalShowContractVisible')" wire:loading.attr="disabled">
                                    {{ __('Hủy') }}
                                </x-jet-secondary-button>

                                <x-jet-button class="ml-2" wire:click="updateContract" wire:loading.attr="disabled">
                                    {{ __('Cập nhật') }}
                                </x-jet-button>                          
                                
                            </x-slot>
                    </x-jet-dialog-modal>
                    
                    {{-- Thanh toán --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                <h3>Thông tin hợp đồng</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Mã lô giữ chỗ: </td>
                                                <td>{{$row->lot_number}}</td>
                                            </tr>
                                            <tr>
                                                <td>Trạng thái: </td>
                                                <td>
                                                    {{$contractStatus[$row->status]}}
                                                    @if($contractStatus[$row->status] === "Trả giữ chỗ" or $$contractStatus[$row->status] === "Bỏ giữ chỗ")
                                                        {{$row->status_created_by}}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Đã ký/ chưa ký: </td>
                                                <td>@if($row->signed != 0) Đã ký @else Chưa ký @endif</td>
                                            </tr>
                                            <tr>
                                                <td>Ngày ký: </td>
                                                <td>{{$row->signed_date}}</td>
                                            </tr>
                                            <tr>
                                                <td>Loại hợp đồng: </td>
                                                <td>{{$row->type}}</td>
                                            </tr>
                                            <tr>
                                                <td>Số hợp đồng: </td>
                                                <td>{{$row->contract_no}}</td>
                                            </tr>
                                            <tr>
                                                <td>Diện tích ký: </td>
                                                <td>{{$row->area_signed}}</td>
                                            </tr>
                                            <tr>
                                                <td>Giá bán: </td>
                                                <td>{{number_format($row->value)}}</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><x-jet-button wire:click="updateShowPayment({{5}})"> Sửa </x-jet-button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                                                       
                        </div>
                    </div><p></p>
                    
                    <x-jet-dialog-modal wire:model="modalShowPaymentVisible">
                            <x-slot name="title">
                                {{ __('Sua hợp đồng') }}
                            </x-slot>

                            <x-slot name="content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-jet-label for="contract_no" value="{{ __('Mã hợp đồng') }}" />
                                        <x-jet-input id="contract_no" class="block mt-1 w-full" type="text" wire:model="contractData.contract_no" />
                                        @error('contractData.contract_no')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="type" value="{{ __('Loại hợp dồng') }}" />
                                        <x-jet-input id="type" class="block mt-1 w-full" type="text" wire:model="contractData.type" />
                                        @error('contractData.type')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="lot_number" value="{{ __('Mã lô') }}" />
                                        <x-jet-input id="lot_number" class="block mt-1 w-full" type="text" wire:model="contractData.lot_number" />
                                        @error('contractData.lot_number')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="area_signed" value="{{ __('Diện tích ký') }}" />
                                        <x-jet-input id="area_signed" class="block mt-1 w-full" type="text" wire:model="contractData.area_signed" />
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
                                            <select class="custom-select" wire:model="contractData.status">                                                       
                                                @foreach ($this->contractStatus as $status)
                                                    <option value="{{$loop->index}}">{{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('contractData.status')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Dự án</label>
                                            </div>
                                            <select class="custom-select" wire:model="contractData.project_id">
                                                <option value="0" selected>Chọn dự án</option>
                                                @foreach($this->projectData as $project)
                                                    <option value="{{$project->id}}">{{$project->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('contractData.project_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-jet-label for="signed_date" value="{{ __('Ngày ký') }}" />
                                        <x-jet-input type="date" wire:model="contractData.signed_date" id="signed_date"/>
                                        @error('contractData.signed_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="signed_date" value="{{ __('Giá bán') }}" />
                                        <x-jet-input type="text" wire:model="contractData.value" id="value"/>
                                        @error('contractData.value')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="payment_date_95" value="{{ __('Ngày thanh toán đủ 95%') }}" />
                                        <x-jet-input type="date" wire:model="paymentData.payment_date_95" id="payment_date_95"/>
                                        @error('paymentData.payment_date_95')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="payment_progress" value="{{ __('Tiến độ thanh toán') }}" />
                                        <x-jet-input type="text" wire:model="paymentData.payment_progress" id="payment_progress"/>
                                        @error('paymentData.payment_progress')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6 flex">
                                        <x-jet-label for="signed" value="{{ __('Đã ký / chưa ký') }}" />
                                        <input id="signed" type="checkbox" wire:model="contractData.signed" class="form-checkbox h-5 w-5 text-green-500 ml-2">
                                        @error('contractData.signed')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                            </x-slot>
                        
                            <x-slot name="footer">
                                <x-jet-secondary-button wire:click="$toggle('modalShowContractVisible')" wire:loading.attr="disabled">
                                    {{ __('Hủy') }}
                                </x-jet-secondary-button>

                                <x-jet-button class="ml-2" wire:click="updateContract" wire:loading.attr="disabled">
                                    {{ __('Cập nhật') }}
                                </x-jet-button>                          
                                
                            </x-slot>
                    </x-jet-dialog-modal>
                    
                    {{-- Pháp lý --}}
                    @if(App\Models\Juridical::where('contract_id',$row->id)->first() != null)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                <h3>Thông tin pháp lý</h3>
                                </div>
                                
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Thông tin hợp đồng: </td>
                                                <td>{{$this->juridicalData['contract_info']}}</td>
                                            </tr>
                                            <tr>
                                                <td>Tình trạng sổ: </td>
                                                <td>{{$this->juridicalData['status']}}</td>
                                            </tr>
                                            <tr>
                                                <td>Ngày công chứng: </td>
                                                <td>{{$this->juridicalData['notarized_date']}}</td>
                                            </tr>
                                            <tr>
                                                <td>Thủ tục đăng bộ: </td>
                                                <td>{{$this->juridicalData['registration_procedures']}}</td>
                                            </tr>
                                            <tr>
                                                <td>Thanh lý hợp đồng: </td>
                                                <td>{{$this->juridicalData['liquidation']}}</td>
                                            </tr>
                                            <tr>
                                                <td>Hồ sơ thu lai của khách hàng: </td>
                                                <td>{{$this->juridicalData['bill_profile']}}</td>
                                            </tr>
                                            <tr>
                                                <td>Bộ phận giữ sổ: </td>
                                                <td>{{$this->bookHolder[$this->juridicalData['book_holder']]}}</td>
                                            </tr>
                                            <tr>
                                                <td>Ngày bàn giao đất: </td>
                                                <td>{{$this->juridicalData['delivery_land_date']}}</td>
                                            </tr>
                                            <tr>
                                                <td>Cam kết thỏa thuận: </td>
                                                <td>{{$this->juridicalData['commitment']}}</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><x-jet-button wire:click="updateShowJuridical({{$this->juridicalData['id']}})"> Sửa </x-jet-button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>                             
                            </div>
                        </div>
                    </div><p></p>
                    @else
                        <div class="row">
                            <div class="col-md-8">Chưa có thông tin</div>
                            <div class="col-md-4"><x-jet-button class="ml-2" wire:click="createShowJuridical">Thêm thông tin pháp  lý</x-jet-button></div>
                        </div><p></p>
                        
                        <x-jet-dialog-modal wire:model="modalFormJuridicalVisible">
                                <x-slot name="title">
                                    {{ __('Thêm thông tin pháp lý') }}
                                </x-slot>

                                <x-slot name="content">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-jet-label for="status" value="{{ __('Tình trạng sổ') }}" />
                                            <x-jet-input id="status" class="block mt-1 w-full" type="text" wire:model="juridicalData.status"/>
                                            @error('juridicalData.status')
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                        <div class="col-md-6">
                                            <x-jet-label for="registration_procedures" value="{{ __('Thủ tục đăng bộ') }}" />
                                            <x-jet-input id="registration_procedures" class="block mt-1 w-full" type="text" wire:model="juridicalData.registration_procedures" />
                                            @error('juridicalData.registration_procedures')
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <x-jet-label for="notarized_date" value="{{ __('Ngày công chứng') }}" />
                                            <x-jet-input type="date" class="block mt-1 w-full" wire:model="juridicalData.notarized_date" id="notarized_date"/>
                                            @error('juridicalData.notarized_date')
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                        <div class="col-md-6">
                                            <x-jet-label for="delivery_land_date" value="{{ __('Ngày bàn giao đất') }}" />
                                            <x-jet-input type="date" class="block mt-1 w-full" wire:model="juridicalData.delivery_land_date" id="delivery_land_date"/>
                                            @error('juridicalData.delivery_land_date')
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputGroupSelect01">Hợp đồng</label>
                                                </div>
                                                <select class="custom-select" wire:model="juridicalData.contract_info">                                                       
                                                    @foreach ($this->contractInfo as $info)
                                                        <option value="{{$loop->index}}">{{ $info }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputGroupSelect01">Bộ phận</label>
                                                </div>
                                                <select class="custom-select" wire:model="juridicalData.book_holder">
                                                    @foreach ($this->bookHolder as $role)
                                                        <option value="{{$loop->index}}">{{ $role }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <x-jet-label for="bill_profile" value="{{ __('Hồ sơ thu lai của khách hàng') }}" />
                                            <x-jet-input type="text" class="block mt-1 w-full" wire:model="juridicalData.bill_profile" id="bill_profile"/>
                                        </div>
                                        <div class="col-md-6">
                                            <x-jet-label for="commitment" value="{{ __('Cam kết thỏa thuận khác') }}" />
                                            <x-jet-input type="text" class="block mt-1 w-full" wire:model="juridicalData.commitment" id="commitment"/>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-6 flex">
                                            <x-jet-label for="liquidation" value="{{ __('Thanh lý hợp đồng') }}" />
                                            <input id="liquidation" type="checkbox" wire:model="juridicalData.liquidation" class="form-checkbox h-5 w-5 text-green-500 ml-2" checked>
                                        </div>
                                    </div>
                                </x-slot>
                            
                                <x-slot name="footer">
                                    <x-jet-secondary-button wire:click="$toggle('modalFormJuridicalVisible')" wire:loading.attr="disabled">
                                        {{ __('Hủy') }}
                                    </x-jet-secondary-button>

                                    @if ($juridicalId)
                                    <x-jet-button class="ml-2" wire:click="updateJuridical" wire:loading.attr="disabled">
                                        {{ __('Cập nhật') }}
                                    </x-jet-button>
                                    @else
                                    <x-jet-button class="ml-2" wire:click="createJuridical({{$row->id}})" wire:loading.attr="disabled">
                                        {{ __('Lưu') }}
                                    </x-jet-button>
                                    @endif
                                    
                                    
                                    
                                </x-slot>
                        </x-jet-dialog-modal>
                        
                    @endif
                </div>
            @endif
        @endforeach
        
    </div>
    </section>
    <!-- <script>
        var picker = new Pikaday({ field: $('#datepicker')[0] });
    </script> -->
</div>