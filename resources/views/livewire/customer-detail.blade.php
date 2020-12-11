<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Thông tin chi tiết khách hàng {{$customerData['name']}}
    </h2>
</x-slot>
<div>
    <section>
        
        <div class="container">
            <p></p>
            <div>
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
            <p></p>
            <div class="container">
                @if(Auth::user()->type != 3)
                <div class="row">
                    <div class="col-md-7"></div>
                    <div class="col-md-2">
                        @if(Auth::user()->type == 1)
                            <x-jet-button wire:click="export">Xuất file</x-jet-button>
                        @endif
                    </div>
                    <div class="col-md-3">
                        
                            <x-jet-button wire:click="createShowContract">Tạo Hợp Đồng</x-jet-button>
                            <x-jet-dialog-modal wire:model.lazy="modalShowContractVisible">
                                @if($contractId)
                                    <x-slot name="title">
                                        {{ __('Sửa hợp đồng') }}
                                    </x-slot>
                                @else
                                    <x-slot name="title">
                                        {{ __('Thêm hợp đồng') }}
                                    </x-slot>
                                @endif
                                <x-slot name="content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-jet-label for="contract_no" value="{{ __('Số hợp đồng') }}" />
                                            <x-jet-input id="contract_no" class="block mt-1 w-full" type="text" wire:model.lazy="contractData.contract_no" autocomplete="off"/>
                                            @error('contractData.contract_no')
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                        <div class="col-md-6">
                                            <x-jet-label for="type" value="{{ __('Loại hợp đồng') }}" />
                                            <x-jet-input id="type" class="block mt-1 w-full" type="text" wire:model.lazy="contractData.type" autocomplete="off"/>
                                            @error('contractData.type')
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <x-jet-label for="lot_number" value="{{ __('Mã lô') }}" />
                                            <x-jet-input id="lot_number" class="block mt-1 w-full" type="text" wire:model.lazy="contractData.lot_number" autocomplete="off"/>
                                            @error('contractData.lot_number')
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                        <div class="col-md-6">
                                            <x-jet-label for="area_signed" value="{{ __('Diện tích ký') }}" />
                                            <x-jet-input id="area_signed" class="block mt-1 w-full" type="number" wire:model.lazy="contractData.area_signed" autocomplete="off"/>
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
                                        @if($this->contractData['status'] != 2)
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
                                            <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="contractData.signed_date" id="signed_date" placeholder="Chọn ngày ký..." autocomplete="off"/>
                                            @error('contractData.signed_date')
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                        <div class="col-md-6">
                                            <x-jet-label for="signed_date" value="{{ __('Giá bán') }}" />
                                            <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="contractData.value" id="value" autocomplete="off"/>
                                            @error('contractData.value')
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                    </div>
                                    @if(!$this->contractId)
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <x-jet-label for="payment_date_95" value="{{ __('Ngày thanh toán đủ 95%') }}" />
                                                <x-jet-input type="text" class="block mt-1 w-full" wire:model="payment_date_95" id="payment_date_95" placeholder="Chọn ngày thanh toán..." autocomplete="off"/>
            
                                            </div>
                                            <div class="col-md-6">
                                                <x-jet-label for="payment_progress" value="{{ __('Tiến độ thanh toán') }}" /> 
                                                <x-jet-input type="text" class="block mt-1 w-full" wire:model="payment_progress" id="payment_progress" autocomplete="off"/>
                                                @error('payment_progress')
                                                <span class="text-danger">{{ $message }}</span>
                                                @endError
                                            </div>
                                        </div>
                                        <script>
                                            $('#payment_date_95').datepicker();
                                            $('#payment_date_95').on('change',function(e){
                                                @this.set('payment_date_95', e.target.value);
                                            });
                                        </script>
                                    @endif
            
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <label class="input-group-text" for="inputGroupSelect01">Dự án</label>
                                                </div>
                                                <select class="custom-select" wire:model="contractData.project_id">
                                                    <option value="0">Chọn dự án</option>
                                                    @foreach($this->projectData as $project)
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
                                            <input id="signed" type="checkbox" wire:model.lazy="contractData.signed" class="form-checkbox h-5 w-5 text-green-500 ml-2 " autocomplete="off">
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
            
                                    @if($this->contractId)
                                        <x-jet-button class="ml-2" wire:click="updateContract" wire:loading.attr="disabled">
                                            {{ __('Cập nhật') }}
                                        </x-jet-button>
                                    @else
                                        <x-jet-button class="ml-2" wire:click="createContract" wire:loading.attr="disabled">
                                            {{ __('Lưu') }}
                                        </x-jet-button>
                                    @endif
                                </x-slot>
                            </x-jet-dialog-modal>
                    </div>
                </div>
                @endif
                {{-- Modal thêm + sửa thông tin hợp đồng --}}
                
                
            </div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ $tab == 'customer' ? 'active' : '' }}" wire:click="$set('tab', 'customer')" href="#">Thông tin</a>
                </li>
                @foreach($contract as $key => $item)
                    <li class="nav-item">
                        <a class="nav-link {{ $tab == 'contract'.$key.'' ? 'active' : '' }}" wire:click="tabChange('contract{{$key}}', {{$item->id}})" href="#">Hợp đồng {{$item->contract_no}}</a>
                    </li>
                @endforeach
            </ul>
            @if($tab == 'customer')
                <div class="tab-pane container">

                    {{--                Thong tin khach hang--}}
                    <p></p>
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <h3>Thông tin cơ bản của khách hàng</h3>
                                </div>

                                @if(Auth::user()->type == 1 or Auth::user()->type == 2)
                                    <div class="col-md-2"><x-jet-button wire:click="updateShowModalCustomer({{$customerData['id']}})"> Sửa </x-jet-button></div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <h5 class="col-md-5"> Họ và Tên: </h5>
                                <div class="col-md-1"></div>
                                <label class="col-md-5">{{$customerData['name']}}</label>
                            </div><hr/>

                            <div class="row">
                                <div class="col-md-1"></div>
                                <h5 class="col-md-5"> CMND: </h5>
                                <div class="col-md-1"></div>
                                <label class="col-md-5">{{$customerData['cmnd']}}</label>
                            </div><hr/>

                            <div class="row">
                                <div class="col-md-1"></div>
                                <h5 class="col-md-5"> Địa Chỉ: </h5>
                                <div class="col-md-1"></div>
                                <label class="col-md-5">{{$customerData['address']}}</label>
                            </div><hr/>

                            <div class="row">
                                <div class="col-md-1"></div>
                                <h5 class="col-md-5"> Hộ Khẩu: </h5>
                                <div class="col-md-1"></div>
                                <label class="col-md-5">{{$customerData['household']}}</label>
                            </div><hr/>

                            <div class="row">
                                <div class="col-md-1"></div>
                                <h5 class="col-md-5"> Ngày Sinh: </h5>
                                <div class="col-md-1"></div>
                                <label class="col-md-5">{{$customerData['birthday']}}</label>
                            </div><hr/>

                            <div class="row">
                                <div class="col-md-1"></div>
                                <h5 class="col-md-5"> Số điện thoại: </h5>
                                <div class="col-md-1"></div>
                                <label class="col-md-5">{{$customerData['phone']}}</label>
                            </div><hr/>

                        </div>
                    </div>

                    <x-jet-dialog-modal wire:model="modalShowCustomerVisible">
                        <x-slot name="title">
                            {{ __('Sửa thông tin khách hàng') }}
                        </x-slot>

                        <x-slot name="content">
                            <div class="row">
                                <div class="col-md-6">
                                    <x-jet-label for="name" value="{{ __('Họ tên khách hàng') }}" />
                                    <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model.lazy="customerData.name" autocomplete="off"/>
                                    @error('customerData.name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="col-md-6">
                                    <x-jet-label for="cmnd" value="{{ __('Cmnd') }}" />
                                    <x-jet-input id="cmnd" class="block mt-1 w-full" type="number" wire:model.lazy="customerData.cmnd" autocomplete="off"/>
                                    @error('customerData.cmnd')
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <x-jet-label for="address" value="{{ __('Địa chỉ') }}" />
                                    <x-jet-input id="address" class="block mt-1 w-full" type="text" wire:model.lazy="customerData.address" autocomplete="off" />
                                    @error('customerData.address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="col-md-6">
                                    <x-jet-label for="household" value="{{ __('Hộ khẩu') }}" />
                                    <x-jet-input id="household" class="block mt-1 w-full" type="text" wire:model.lazy="customerData.household" autocomplete="off"/>
                                    @error('customerData.household')
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <x-jet-label for="birthday" value="{{ __('Ngày sinh') }}" />
                                    <x-jet-input type="text" class="block mt-1 w-full" wire:model="customerData.birthday" id="birthday" placeholder="Chọn ngày sinh..." autocomplete="off"/>
                                    @error('customerData.birthday')
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <script>
                                    $('#birthday').datepicker({ 
                                        yearRange: "-100:+0" ,
                                    });
                                    $('#birthday').on('change',function(e){
                                        @this.set('customerData.birthday', e.target.value);
                                    });
                                </script>
                                <div class="col-md-6">
                                    <x-jet-label for="phone" value="{{ __('Số điện thoại') }}" />
                                    <x-jet-input type="number" class="block mt-1 w-full" wire:model.lazy="customerData.phone" id="phone" autocomplete="off"/>
                                    @error('customerData.phone')
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                            </div>

                        </x-slot>

                        <x-slot name="footer">
                            <x-jet-secondary-button wire:click="$toggle('modalShowCustomerVisible')" wire:loading.attr="disabled">
                                {{ __('Hủy') }}
                            </x-jet-secondary-button>

                            <x-jet-button class="ml-2" wire:click="updateCustomer" wire:loading.attr="disabled">
                                {{ __('Cập nhật') }}
                            </x-jet-button>

                        </x-slot>
                    </x-jet-dialog-modal>
                </div>
                
            @endif

            <p></p>
            @foreach($contract as $key => $row)
                @if($tab == 'contract'.$key.'')
                    <div class="tab-pane container">

                        {{-- @livewire('contract.contract-detail', ['id' => $row->id], key($row->id)) --}}
                        
                        {{-- Thông tin Hợp đồng --}}
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3>Thông tin hợp đồng</h3>
                                    </div>
                                    @if(Auth::user()->type != 3)
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2"><x-jet-button wire:click="updateShowContract({{$row->id}})"> Sửa </x-jet-button></div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="col-md-5"> Mã lô giữ chỗ: </h5>
                                    <div class="col-md-1"></div>
                                    <label class="col-md-5">{{$row->lot_number}}</label>
                                </div><hr/>

                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="col-md-5"> Trạng thái: </h5>
                                    <div class="col-md-1"></div>
                                    <label class="col-md-5">
                                        @if(isset($row->status_created_by))
                                            {{$contractStatusCreated[$row->status_created_by]}} -
                                        @endif
                                        {{$contractStatus[$row->status]}}
                                    </label>
                                </div><hr/>

                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="col-md-5"> Đã ký/ Chưa ký:: </h5>
                                    <div class="col-md-1"></div>
                                    <label class="col-md-5">@if($row->signed != 0) Đã ký @else Chưa ký @endif</label>
                                </div><hr/>

                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="col-md-5"> Ngày ký: </h5>
                                    <div class="col-md-1"></div>
                                    <label class="col-md-5">{{$row->signed_date}}</label>
                                </div><hr/>

                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="col-md-5"> Loại hợp đồng: </h5>
                                    <div class="col-md-1"></div>
                                    <label class="col-md-5">{{$row->type}}</label>
                                </div><hr/>

                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="col-md-5"> Số hợp đồng: </h5>
                                    <div class="col-md-1"></div>
                                    <label class="col-md-5">{{$row->contract_no}}</label>
                                </div><hr/>

                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="col-md-5"> Diện tích ký: </h5>
                                    <div class="col-md-1"></div>
                                    <label class="col-md-5">{{$row->area_signed}}</label>
                                </div><hr/>

                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="col-md-5"> Giá bán: </h5>
                                    <div class="col-md-1"></div>
                                    <label class="col-md-5">{{$row->value}}</label>
                                </div><hr/>

                            </div>
                        </div>
                        <p></p>

                        

                        {{-- Thông tin thanh toán và khách hàng trễ hạn --}}
                        {{-- @livewire('payment.payment-detail', ['id' => $row->id], key($row->id)) --}}
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3>Thông tin thanh toán</h3>
                                    </div>
                                    @if(Auth::user()->type != 3)
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2"><x-jet-button wire:click="updateShowPaymentAndBill({{$paymentData['id']}})"> Sửa </x-jet-button></div>
                                    @endif
                                </div>
                            </div>
                        
                            <div class="card-body">
                        
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="col-md-5"> Tiến độ thanh toán: </h5>
                                    <div class="col-md-1"></div>
                                    <label class="col-md-5">{{$paymentData['payment_progress']}}</label>
                                </div><hr/>
                        
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="col-md-5"> Ngày thanh toán đủ 95%: </h5>
                                    <div class="col-md-1"></div>
                                    <label class="col-md-5">
                                        @if(!isset($paymentData['payment_date_95']))
                        
                                        @else
                                            {{$paymentData['payment_date_95']}}
                                        @endif
                                        
                                    </label>
                                </div><hr/>
                        
                                {{-- Thong tin tre han --}}
                        
                                @if(isset($billlateId))
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Ngày trễ: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$billlateData['day_late']}}</label>
                                    </div><hr/>
                        
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Đợt trễ: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$billlateData['batch_late']}}</label>
                                    </div><hr/>
                        
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Số tiền trễ:  </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$billlateData['money_late']}}</label>
                                    </div><hr/>
                        
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Lãi phạt:  </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$billlateData['citation_rate']}}</label>
                                    </div><hr/>
                        
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Số lần đã gửi thông báo:  </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$billlateData['number_notifi']}}</label>
                                    </div><hr/>
                        
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Văn bản, phương thức:  </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$billlateData['document']}}</label>
                                    </div><hr/>
                        
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Ngày khách nhận thông báo:  </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$billlateData['receipt_date']}}</label>
                                    </div><hr/>
                        
                                @else
                                @if(Auth::user()->type != 3)
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-5"><x-jet-button wire:click="createShowModalBillLate({{$this->paymentId}})"> {{ __('Thêm thanh toán trễ hạn') }} </x-jet-button></div>
                                    </div>
                                @endif
                                @endif
                        
                            </div>
                        </div>
                        <p></p>

                        {{-- Modal thêm + sửa thông tin thanh toán và khách hàng trễ hạn --}}
                        @if($billlateId)
                        <x-jet-dialog-modal wire:model="modalShowPaymentVisible">
                            <x-slot name="title">
                                
                                    {{ __('Sửa  thông tin thanh toán') }}
                                
                            </x-slot>

                            <x-slot name="content">
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-jet-label for="payment_progress" value="{{ __('Tiến độ thanh toán') }}" />
                                            <x-jet-input id="payment_progress" class="block mt-1 w-full" type="text" wire:model.lazy="paymentData.payment_progress"  autocomplete="off"/>
                                            @error('paymentData.payment_progress')
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                        <div class="col-md-6">
                                            <x-jet-label for="payment_date_95_2" value="{{ __('Ngày thanh toán đủ 95%') }}" />
                                            <x-jet-input id="payment_date_95_2" class="block mt-1 w-full" type="text" wire:model="paymentData.payment_date_95" placeholder="Chọn ngày thanh toán..." autocomplete="off"/>
                                            @error('paymentData.payment_date_95')
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                    </div>
                                    

                                
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="day_late" value="{{ __('Ngày trễ') }}" />
                                        <x-jet-input type="text" id="day_late"  class="block mt-1 w-full"  wire:model="billlateData.day_late" placeholder="Chọn ngày trễ..." autocomplete="off"/>
                                        @error('billlateData.day_late')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="batch_late" value="{{ __('Đợt trễ') }}" />
                                        <x-jet-input id="batch_late" class="block mt-1 w-full" type="text" wire:model.lazy="billlateData.batch_late" autocomplete="off" />
                                        @error('billlateData.batch_late')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="money_late" value="{{ __('Số tiền trễ') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="billlateData.money_late" id="money_late" autocomplete="off"/>
                                        @error('billlateData.money_late')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="citation_rate" value="{{ __('Lãi phạt') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="billlateData.citation_rate" id="citation_rate" autocomplete="off"/>
                                        @error('billlateData.citation_rate')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="number_notifi" value="{{ __('Số lần đã gửi thông báo') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="billlateData.number_notifi" id="number_notifi" autocomplete="off"/>
                                        @error('billlateData.number_notifi')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="receipt_date" value="{{ __('Ngày khách nhận thông báo') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model="billlateData.receipt_date" id="receipt_date" placeholder="Chọn ngày nhận thông báo..." autocomplete="off"/>
                                        @error('billlateData.receipt_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="document" value="{{ __('Văn bản, phương thức') }}" />
                                        <x-jet-input type="text" wire:model.lazy="billlateData.document" id="document" class="block mt-1 w-full" autocomplete="off"/>
                                        @error('billlateData.document')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                                

                            </x-slot>

                            <x-slot name="footer">
                                <x-jet-secondary-button wire:click="$toggle('modalShowPaymentVisible')" wire:loading.attr="disabled">
                                    {{ __('Hủy') }}
                                </x-jet-secondary-button>

                                @if($paymentId && $billlateId)
                                    <x-jet-button class="ml-2" wire:click="updatePaymentAndBill" wire:loading.attr="disabled">
                                        {{ __('Cập nhật') }}
                                    </x-jet-button>
                                @else
                                    <x-jet-button class="ml-2" wire:click="createBillLate" wire:loading.attr="disabled">
                                        {{ __('Lưu') }}
                                    </x-jet-button>
                                @endif

                            </x-slot>
                        </x-jet-dialog-modal>
                        @else

                        <x-jet-dialog-modal wire:model="modalShowPaymentVisible">
                            <x-slot name="title">
                                
                                    {{ __('Sửa  thông tin thanh toán') }}
                                
                            </x-slot>

                            <x-slot name="content">
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-jet-label for="payment_progress" value="{{ __('Tiến độ thanh toán') }}" />
                                            <x-jet-input id="payment_progress" class="block mt-1 w-full" type="text" wire:model="paymentData.payment_progress"  autocomplete="off"/>
                                            @error('paymentData.payment_progress')
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                        <div class="col-md-6">
                                            <x-jet-label for="payment_date_95_2" value="{{ __('Ngày thanh toán đủ 95%') }}" />
                                            <x-jet-input id="payment_date_95_2" class="block mt-1 w-full" type="text" wire:model="paymentData.payment_date_95" placeholder="Chọn ngày thanh toán..." autocomplete="off"/>
                                            
                                        </div>
                                    </div>
                            
                                

                            </x-slot>

                            <x-slot name="footer">
                                <x-jet-secondary-button wire:click="$toggle('modalShowPaymentVisible')" wire:loading.attr="disabled">
                                    {{ __('Hủy') }}
                                </x-jet-secondary-button>

                                    <x-jet-button class="ml-2" wire:click="updatePaymentAndBill" wire:loading.attr="disabled">
                                        {{ __('Cập nhật') }}
                                    </x-jet-button>
                                

                            </x-slot>
                        </x-jet-dialog-modal>

                        <x-jet-dialog-modal wire:model="modalCreateBilllate">
                            
                            <x-slot name="title">
                            

                                {{ __('Thêm thanh toán trễ hạn') }}
                            </x-slot>
                            <x-slot name="content">
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="day_late" value="{{ __('Ngày trễ') }}" />
                                        <x-jet-input type="text" id="day_late"  class="block mt-1 w-full"  wire:model="billlateData.day_late" placeholder="Chọn ngày trễ..." autocomplete="off"/>
                                        @error('billlateData.day_late')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="batch_late" value="{{ __('Đợt trễ') }}" />
                                        <x-jet-input id="batch_late" class="block mt-1 w-full" type="text" wire:model.lazy="billlateData.batch_late" autocomplete="off" />
                                        @error('billlateData.batch_late')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="money_late" value="{{ __('Số tiền trễ') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="billlateData.money_late" id="money_late" autocomplete="off"/>
                                        @error('billlateData.money_late')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="citation_rate" value="{{ __('Lãi phạt') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="billlateData.citation_rate" id="citation_rate" autocomplete="off"/>
                                        @error('billlateData.citation_rate')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="number_notifi" value="{{ __('Số lần đã gửi thông báo') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="billlateData.number_notifi" id="number_notifi" autocomplete="off"/>
                                        @error('billlateData.number_notifi')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="receipt_date" value="{{ __('Ngày khách nhận thông báo') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model="billlateData.receipt_date" id="receipt_date" placeholder="Chọn ngày nhận thông báo..." autocomplete="off"/>
                                        @error('billlateData.receipt_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="document" value="{{ __('Văn bản, phương thức') }}" />
                                        <x-jet-input type="text" wire:model.lazy="billlateData.document" id="document" class="block mt-1 w-full" autocomplete="off"/>
                                        @error('billlateData.document')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                            </x-slot>
                                <x-slot name="footer">
                                    <x-jet-secondary-button wire:click="$toggle('modalCreateBilllate')" wire:loading.attr="disabled">
                                        {{ __('Hủy') }}
                                    </x-jet-secondary-button>      
                                        <x-jet-button class="ml-2" wire:click="createBillLate" wire:loading.attr="disabled">
                                            {{ __('Lưu') }}
                                        </x-jet-button>
                                    

                                </x-slot>
                        </x-jet-dialog-modal>
                        @endif

                        {{-- Thông tin pháp lý --}}
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3>Thông tin pháp lý</h3>
                                    </div>
                                    @if($this->juridicalId)
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2"><x-jet-button wire:click="updateShowJuridical({{$this->juridicalId}})"> Sửa </x-jet-button></div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">

                                @if($juridicalId)
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Thông tin hợp đồng: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$this->contractInfo[$this->juridicalData['contract_info']]}}</label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Tình trạng sổ: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$this->juridicalData['status']}}</label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Ngày công chứng: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">
                                            @if(!isset($juridicalData['notarized_date']))
                                                
                                            @else
                                                {{ $juridicalData['notarized_date'] }}
                                            @endif
                                        </label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Thủ tục đăng bộ: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$this->juridicalData['registration_procedures']}}</label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Thanh lý hợp đồng: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">
                                            @if($this->juridicalData['liquidation'] == true)
                                                <input type='checkbox' checked disabled/>
                                            @endif
                                        </label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Bộ phận giữ sổ: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$this->bookHolder[$this->juridicalData['book_holder']]}}</label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Hồ sơ thu lai của khách hàng: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">
                                            @if(!isset($juridicalData['bill_profile']))
                                                
                                            @else
                                                {{ $juridicalData['bill_profile'] }}
                                            @endif
                                        </label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Ngày bàn giao đất: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">
                                            @if(!isset($juridicalData['delivery_land_date']))
                                                
                                            @else
                                                {{ $juridicalData['delivery_land_date'] }}
                                            @endif
                                        </label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Cam kết thỏa thuận: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">
                                            @if(!isset($juridicalData['commitment']))
                                                
                                            @else
                                                {{ $juridicalData['commitment'] }}
                                            @endif
                                        </label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Ngày bàn giao sổ: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">
                                            @if(!isset($juridicalData['delivery_book_date']))
                                                
                                            @else
                                                {{ $juridicalData['delivery_book_date'] }}
                                            @endif
                                        </label>
                                    </div>


                                @else
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-5"><x-jet-button wire:click="createShowJuridical">{{ __('Thêm thông tin pháp lý') }}</x-jet-button></div>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <p></p>

                        {{-- Modal thêm + sửa thông tin pháp lý --}}
                        <x-jet-dialog-modal wire:model="modalShowJuridicalVisible">
                            <x-slot name="title">

                                {{ __('Thêm thông tin pháp lý') }}

                            </x-slot>

                            <x-slot name="content">

                                <div class="row">
                                    <div class="col-md-6">
                                        <x-jet-label for="status" value="{{ __('Tình trạng sổ') }}" />
                                        <x-jet-input id="status" class="block mt-1 w-full" type="text" wire:model.lazy="juridicalData.status" autocomplete="off"/>
                                        @error('juridicalData.status')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="registration_procedures" value="{{ __('Thủ tục đăng bộ') }}" />
                                        <x-jet-input id="registration_procedures" class="block mt-1 w-full" type="text" wire:model.lazy="juridicalData.registration_procedures" autocomplete="off"/>
                                        @error('juridicalData.registration_procedures')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="notarized_date" value="{{ __('Ngày công chứng') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="juridicalData.notarized_date" id="notarized_date" placeholder="Chọn ngày công chứng..." autocomplete="off"/>

                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="delivery_land_date" value="{{ __('Ngày bàn giao đất') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="juridicalData.delivery_land_date" id="delivery_land_date" placeholder="Chọn ngày bàn giao đất..." autocomplete="off"/>

                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Hợp đồng</label>
                                            </div>
                                            <select class="custom-select" wire:model.lazy="juridicalData.contract_info">
                                                <option>Chọn hợp đồng</option>
                                                @foreach ($this->contractInfo as $info)
                                                    <option value="{{$loop->index}}">{{ $info }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('juridicalData.contract_info')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Bộ phận</label>
                                            </div>
                                            <select class="custom-select" wire:model="juridicalData.book_holder">
                                                <option>Chọn bộ phận</option>
                                                @foreach ($this->bookHolder as $role)
                                                    <option value="{{$loop->index}}">{{ $role }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('juridicalData.book_holder')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="bill_profile" value="{{ __('Hồ sơ thu lai của khách hàng') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="juridicalData.bill_profile" id="bill_profile" autocomplete="off"/>

                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="commitment" value="{{ __('Cam kết thỏa thuận khác') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model.lazy="juridicalData.commitment" id="commitment" autocomplete="off"/>

                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="delivery_book_date" value="{{ __('Ngày bàn giao sổ') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" id="delivery_book_date" wire:model="juridicalData.delivery_book_date"  placeholder="Chọn ngày bàn giao sổ..." autocomplete="off"/>

                                    </div>
                                    <div class="col-md-6 flex">
                                        <x-jet-label for="liquidation" value="{{ __('Thanh lý hợp đồng') }}" />
                                        <x-jet-input id="liquidation" type="checkbox" wire:model.lazy="juridicalData.liquidation" class="form-checkbox h-5 w-5 text-green-500 ml-2" autocomplete="off"/>

                                    </div>
                                </div>

                            </x-slot>

                            <x-slot name="footer">
                                <x-jet-secondary-button wire:click="$toggle('modalShowJuridicalVisible')" wire:loading.attr="disabled">
                                    {{ __('Hủy') }}
                                </x-jet-secondary-button>

                                @if($this->juridicalId)
                                    <x-jet-button class="ml-2" wire:click="updateJuridical" wire:loading.attr="disabled">
                                        {{ __('Cập nhật') }}
                                    </x-jet-button>
                                @else
                                    <x-jet-button class="ml-2" wire:click="createJuridical" wire:loading.attr="disabled">
                                        {{ __('Lưu') }}
                                    </x-jet-button>
                                @endif

                            </x-slot>
                        </x-jet-dialog-modal>

                    </div>

                    <script>
                        $('#day_late').datepicker();
                        $('#day_late').on('change',function(e){
                            @this.set('billlateData.day_late', e.target.value);
                        });


                        $('#receipt_date').datepicker();
                        $('#receipt_date').on('change',function(e){
                            @this.set('billlateData.receipt_date', e.target.value);
                        });


                        $('#notarized_date').datepicker();
                        $('#notarized_date').on('change',function(e){
                            @this.set('juridicalData.notarized_date', e.target.value);
                        });

                        $('#delivery_land_date').datepicker();
                        $('#delivery_land_date').on('change',function(e){
                            @this.set('juridicalData.delivery_land_date', e.target.value);
                        });

                        $('#delivery_book_date').datepicker();
                        $('#delivery_book_date').on('change',function(e){
                            @this.set('juridicalData.delivery_book_date', e.target.value);
                        });
                        $('#payment_date_95').datepicker();
                        $('#payment_date_95').on('change',function(e){
                            @this.set('payment_date_95', e.target.value);
                        });

                        $('#payment_date_95_2').datepicker();
                        $('#payment_date_95_2').on('change',function(e){
                            @this.set('paymentData.payment_date_95', e.target.value);
                        });
                    </script>
                @endif
            @endforeach

        </div>
    </section>
    <!-- <script>
        var picker = new Pikaday({ field: $('#datepicker')[0] });
    </script> -->
</div>
<script>

    

    $('#signed_date').datepicker();
    $('#signed_date').on('change',function(e){
        @this.set('contractData.signed_date', e.target.value);
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
