<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Quản lý khách hàng
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
                <div class="row">
                    <div class="col-md-9"></div>
                    <div class="col-md-3"><x-jet-button wire:click="createShowContract">Tạo Hợp Đồng</x-jet-button></div>
                </div>
                {{-- Modal thêm + sửa thông tin hợp đồng --}}
                <x-jet-dialog-modal wire:model="modalShowContractVisible">
                    @if($this->contractId)
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
                        @if(!$this->contractId)
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <x-jet-label for="payment_date_95" value="{{ __('Ngày thanh toán đủ 95%') }}" />
                                    <x-jet-input type="date" wire:model="paymentData.payment_date_95" id="payment_date_95"/>
                                </div>
                                <div class="col-md-6">
                                    <x-jet-label for="payment_progress" value="{{ __('Tiến độ thanh toán') }}" />
                                    <x-jet-input type="text" wire:model="paymentData.payment_progress" id="payment_progress"/>
                                </div>
                            </div>
                        @endif
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

                    {{--                Thong tin khach hang--}}
                    <p></p>
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <h3>Thông tin cơ bản của khách hàng</h3>
                                </div>
                                @if(Auth::user()->type == 1)
                                <div class="col-md-2"><x-jet-button wire:click="export"> Xuất File </x-jet-button></div>
                                @endif
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
                            {{ __('Sửa thong tin khach hang') }}
                        </x-slot>

                        <x-slot name="content">
                            <div class="row">
                                <div class="col-md-6">
                                    <x-jet-label for="name" value="{{ __('Ho ten khach hang') }}" />
                                    <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model="customerData.name" />
                                    @error('customerData.name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="col-md-6">
                                    <x-jet-label for="cmnd" value="{{ __('Cmnd') }}" />
                                    <x-jet-input id="cmnd" class="block mt-1 w-full" type="text" wire:model="customerData.cmnd" />
                                    @error('customerData.cmnd')
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <x-jet-label for="address" value="{{ __('Dia chi') }}" />
                                    <x-jet-input id="address" class="block mt-1 w-full" type="text" wire:model="customerData.address" />
                                    @error('customerData.address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="col-md-6">
                                    <x-jet-label for="household" value="{{ __('Ho khau') }}" />
                                    <x-jet-input id="household" class="block mt-1 w-full" type="text" wire:model="customerData.household" />
                                    @error('customerData.household')
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <x-jet-label for="birthday" value="{{ __('Ngày ký') }}" />
                                    <x-jet-input type="date" class="block mt-1 w-full" wire:model="customerData.birthday" id="birthday"/>
                                    @error('customerData.birthday')
                                    <span class="text-danger">{{ $message }}</span>
                                    @endError
                                </div>
                                <div class="col-md-6">
                                    <x-jet-label for="phone" value="{{ __('Số điện thoại') }}" />
                                    <x-jet-input type="number" class="block mt-1 w-full" wire:model="customerData.phone" id="phone"/>
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

                        {{-- Thông tin Hợp đồng --}}
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3>Thông tin hợp đồng</h3>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2"><x-jet-button wire:click="updateShowContract({{$row->id}})"> Sửa </x-jet-button></div>
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
                                    <label class="col-md-5">{{$contractStatus[$row->status]}}</label>
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

                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3>Thông tin thanh toán</h3>
                                    </div>
                                    @if($billlateId)
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2"><x-jet-button wire:click="updateShowPaymentAndBill({{$billlateId}})"> Sửa </x-jet-button></div>
                                    @endif
                                </div>
                            </div>

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="col-md-5"> Tiến độ thanh toán: </h5>
                                    <div class="col-md-1"></div>
                                    <label class="col-md-5">{{$this->paymentData['payment_progress']}}</label>
                                </div><hr/>

                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <h5 class="col-md-5"> Ngày thanh toán đủ 95%: </h5>
                                    <div class="col-md-1"></div>
                                    <label class="col-md-5">{{$this->paymentData['payment_date_95']}}</label>
                                </div><hr/>

                                {{-- Thong tin tre han --}}

                                @if($infoBillLate == true)
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Ngày trễ: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$this->billlateData['day_late']}}</label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Đợt trễ: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$this->billlateData['batch_late']}}</label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Số tiền trễ:  </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$this->billlateData['money_late']}}</label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Lãi phạt:  </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$this->billlateData['citation_rate']}}</label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Số lần đã gửi thông báo:  </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$this->billlateData['number_notifi']}}</label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Văn bản, phương thức:  </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$this->billlateData['document']}}</label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Ngày khách nhận thông báo:  </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$this->billlateData['receipt_date']}}</label>
                                    </div><hr/>

                                @else
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-5"><x-jet-button wire:click="createShowModalBillLate({{$this->paymentId}})"> {{ __('Thêm thanh toán trễ hạn') }} </x-jet-button></div>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <p></p>

                        {{-- Modal thêm + sửa thông tin thanh toán và khách hàng trễ hạn --}}
                        <x-jet-dialog-modal wire:model="modalShowPaymentVisible">
                            <x-slot name="title">
                                @if($billlateId)
                                    {{ __('Sửa  thông tin thanh toán') }}
                                @else
                                    {{ __('Thêm thanh toán trễ hạn') }}
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                @if($billlateId)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-jet-label for="payment_progress" value="{{ __('Tiến độ thanh toán') }}" />
                                            <x-jet-input id="payment_progress" class="block mt-1 w-full" type="text" wire:model="paymentData.payment_progress"  />
                                            @error('paymentData.payment_progress')
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                        <div class="col-md-6">
                                            <x-jet-label for="payment_date_95" value="{{ __('Ngày thanh toán đủ 95%') }}" />
                                            <x-jet-input id="payment_date_95" class="block mt-1 w-full" type="date" wire:model="paymentData.payment_date_95" />
                                            @error('paymentData.payment_date_95')
                                            <span class="text-danger">{{ $message }}</span>
                                            @endError
                                        </div>
                                    </div>
                                @endif


                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="day_late" value="{{ __('Ngày trễ') }}" />
                                        <x-jet-input id="day_late" class="block mt-1 w-full" type="date" wire:model="billlateData.day_late" />
                                        @error('billlateData.day_late')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="batch_late" value="{{ __('Đợt trễ') }}" />
                                        <x-jet-input id="batch_late" class="block mt-1 w-full" type="text" wire:model="billlateData.batch_late" />
                                        @error('billlateData.batch_late')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="money_late" value="{{ __('Số tiền trễ') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model="billlateData.money_late" id="money_late"/>
                                        @error('billlateData.money_late')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="citation_rate" value="{{ __('Lãi phạt') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model="billlateData.citation_rate" id="citation_rate"/>
                                        @error('billlateData.citation_rate')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="number_notifi" value="{{ __('Số lần đã gửi thông báo') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model="billlateData.number_notifi" id="number_notifi"/>
                                        @error('billlateData.number_notifi')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="receipt_date" value="{{ __('Ngày khách nhận thông báo') }}" />
                                        <x-jet-input type="date" class="block mt-1 w-full" wire:model="billlateData.receipt_date" id="receipt_date"/>
                                        @error('billlateData.receipt_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="document" value="{{ __('Văn bản, phương thức') }}" />
                                        <x-jet-input type="text" wire:model="billlateData.document" id="document" class="block mt-1 w-full"/>
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

                                @if($this->juridicalId)
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Thông tin hợp đồng: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$this->juridicalData['contract_info']}}</label>
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
                                        <label class="col-md-5">{{$this->juridicalData['notarized_date']}}</label>
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
                                        <label class="col-md-5">{{$this->juridicalData['liquidation']}}</label>
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
                                        <label class="col-md-5">{{$this->juridicalData['bill_profile']}}</label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Ngày bàn giao đất: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$this->juridicalData['delivery_land_date']}}</label>
                                    </div><hr/>

                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <h5 class="col-md-5"> Cam kết thỏa thuận: </h5>
                                        <div class="col-md-1"></div>
                                        <label class="col-md-5">{{$this->juridicalData['commitment']}}</label>
                                    </div><hr/>


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

                                {{ __('Thêm thong tin phap ly') }}

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
                                        @error('juridicalData.bill_profile')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-label for="commitment" value="{{ __('Cam kết thỏa thuận khác') }}" />
                                        <x-jet-input type="text" class="block mt-1 w-full" wire:model="juridicalData.commitment" id="commitment"/>
                                        @error('juridicalData.commitment')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <x-jet-label for="delivery_book_date" value="{{ __('Ngày bàn giao sổ') }}" />
                                        <x-jet-input type="date" class="block mt-1 w-full" wire:model="juridicalData.delivery_book_date" id="delivery_book_date"/>
                                        @error('juridicalData.delivery_book_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
                                    </div>
                                    <div class="col-md-6 flex">
                                        <x-jet-label for="liquidation" value="{{ __('Thanh lý hợp đồng') }}" />
                                        <x-jet-input id="liquidation" type="checkbox" wire:model="juridicalData.liquidation" class="form-checkbox h-5 w-5 text-green-500 ml-2"/>
                                        @error('juridicalData.liquidation')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endError
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
                @endif
            @endforeach

        </div>
    </section>
    <!-- <script>
        var picker = new Pikaday({ field: $('#datepicker')[0] });
    </script> -->
</div>
