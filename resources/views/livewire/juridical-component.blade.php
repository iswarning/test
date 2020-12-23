<div>
    {{-- Thông tin pháp lý --}}
    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8">
                    <h3>Thông tin pháp lý</h3>
                </div>
                @if($juridical)
                <div class="col-md-2"></div>
                <div class="col-md-2"><x-jet-button wire:click="updateShowJuridical({{$juridical->id}})"> Sửa </x-jet-button></div>
                @endif
            </div>
        </div>
        <div class="card-body">

            @if($juridical)
                <div class="row">
                    <div class="col-md-1"></div>
                    <h5 class="col-md-5"> Thông tin hợp đồng: </h5>
                    <div class="col-md-1"></div>
                    <label class="col-md-5">{{$this->contractInfo[$juridical->contract_info]}}</label>
                </div><hr/>

                <div class="row">
                    <div class="col-md-1"></div>
                    <h5 class="col-md-5"> Tình trạng sổ: </h5>
                    <div class="col-md-1"></div>
                    <label class="col-md-5">{{$juridical->status}}</label>
                </div><hr/>

                <div class="row">
                    <div class="col-md-1"></div>
                    <h5 class="col-md-5"> Ngày công chứng: </h5>
                    <div class="col-md-1"></div>
                    <label class="col-md-5">
                        @if(!isset($juridical->notarized_date))
                            
                        @else
                            {{ $juridical->notarized_date }}
                        @endif
                    </label>
                </div><hr/>

                <div class="row">
                    <div class="col-md-1"></div>
                    <h5 class="col-md-5"> Thủ tục đăng bộ: </h5>
                    <div class="col-md-1"></div>
                    <label class="col-md-5">{{$juridical->registration_procedures}}</label>
                </div><hr/>

                <div class="row">
                    <div class="col-md-1"></div>
                    <h5 class="col-md-5"> Thanh lý hợp đồng: </h5>
                    <div class="col-md-1"></div>
                    <label class="col-md-5">
                        @if($juridical->liquidation == true)
                            <input type='checkbox' checked disabled/>
                        @endif
                    </label>
                </div><hr/>

                <div class="row">
                    <div class="col-md-1"></div>
                    <h5 class="col-md-5"> Bộ phận giữ sổ: </h5>
                    <div class="col-md-1"></div>
                    <label class="col-md-5">{{$this->bookHolder[$juridical->book_holder]}}</label>
                </div><hr/>

                <div class="row">
                    <div class="col-md-1"></div>
                    <h5 class="col-md-5"> Hồ sơ thu lai của khách hàng: </h5>
                    <div class="col-md-1"></div>
                    <label class="col-md-5">
                        @if(!isset($juridical->bill_profile))
                            
                        @else
                            {{ $juridical->bill_profile }}
                        @endif
                    </label>
                </div><hr/>

                <div class="row">
                    <div class="col-md-1"></div>
                    <h5 class="col-md-5"> Ngày bàn giao đất: </h5>
                    <div class="col-md-1"></div>
                    <label class="col-md-5">
                        @if(!isset($juridical->delivery_land_date))
                            
                        @else
                            {{ $juridical->delivery_land_date }}
                        @endif
                    </label>
                </div><hr/>

                <div class="row">
                    <div class="col-md-1"></div>
                    <h5 class="col-md-5"> Cam kết thỏa thuận: </h5>
                    <div class="col-md-1"></div>
                    <label class="col-md-5">
                        @if(!isset($juridical->commitment))
                            
                        @else
                            {{ $juridical->commitment }}
                        @endif
                    </label>
                </div><hr/>

                <div class="row">
                    <div class="col-md-1"></div>
                    <h5 class="col-md-5"> Ngày bàn giao sổ: </h5>
                    <div class="col-md-1"></div>
                    <label class="col-md-5">
                        @if(!isset($juridical->delivery_book_date))
                            
                        @else
                            {{ $juridical->delivery_book_date }}
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
                    <x-jet-label for="bill_profile" value="{{ __('Hồ sơ thu lại của khách hàng') }}" />
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

            @if($juridical)
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
</script>