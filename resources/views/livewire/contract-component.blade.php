<div>
    {{-- Thông tin Hợp đồng --}}
    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8">
                    <h3>Thông tin hợp đồng</h3>
                </div>
                @if(Auth::user()->type != 3)
                <div class="col-md-2"></div>
                <div class="col-md-2"><x-jet-button wire:click="updateShowContract({{$contract->id}})"> Sửa </x-jet-button></div>
                @endif
            </div>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-1"></div>
                <h5 class="col-md-5"> Mã lô giữ chỗ: </h5>
                <div class="col-md-1"></div>
                <label class="col-md-5">{{$contract->lot_number}}</label>
            </div><hr/>

            <div class="row">
                <div class="col-md-1"></div>
                <h5 class="col-md-5"> Trạng thái: </h5>
                <div class="col-md-1"></div>
                <label class="col-md-5">
                    @if(isset($contract->status_created_by))
                        {{$contractStatusCreated[$contract->status_created_by]}} -
                    @endif
                    {{$contractStatus[$contract->status]}}
                </label>
            </div><hr/>

            <div class="row">
                <div class="col-md-1"></div>
                <h5 class="col-md-5"> Đã ký/ Chưa ký:: </h5>
                <div class="col-md-1"></div>
                <label class="col-md-5">@if($contract->signed != 0) Đã ký @else Chưa ký @endif</label>
            </div><hr/>

            <div class="row">
                <div class="col-md-1"></div>
                <h5 class="col-md-5"> Ngày ký: </h5>
                <div class="col-md-1"></div>
                <label class="col-md-5">{{$contract->signed_date}}</label>
            </div><hr/>

            <div class="row">
                <div class="col-md-1"></div>
                <h5 class="col-md-5"> Loại hợp đồng: </h5>
                <div class="col-md-1"></div>
                <label class="col-md-5">{{$contract->type}}</label>
            </div><hr/>

            <div class="row">
                <div class="col-md-1"></div>
                <h5 class="col-md-5"> Số hợp đồng: </h5>
                <div class="col-md-1"></div>
                <label class="col-md-5">{{$contract->contract_no}}</label>
            </div><hr/>

            <div class="row">
                <div class="col-md-1"></div>
                <h5 class="col-md-5"> Diện tích ký: </h5>
                <div class="col-md-1"></div>
                <label class="col-md-5">{{$contract->area_signed}}</label>
            </div><hr/>

            <div class="row">
                <div class="col-md-1"></div>
                <h5 class="col-md-5"> Giá bán: </h5>
                <div class="col-md-1"></div>
                <label class="col-md-5">{{$contract->value}}</label>
            </div><hr/>

        </div>
    </div>
    <p></p>

    <x-jet-dialog-modal wire:model="modalShowContractVisible">
            <x-slot name="title">
                {{ __('Sửa hợp đồng') }}
            </x-slot>
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
                            
                            @foreach ($this->contractStatus as $item)
                                <option value="{{$loop->index}}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('contractData.status')
                    <span class="text-danger">{{ $message }}</span>
                    @endError
                </div>
                @if($contract->status != 2)
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

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Dự án</label>
                        </div>
                        <select class="custom-select" wire:model="contractData.project_id">
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

                <x-jet-button class="ml-2" wire:click="updateContract" wire:loading.attr="disabled">
                    {{ __('Cập nhật') }}
                </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
<script>
    $('#signed_date').datepicker();
        $('#signed_date').on('change',function(e){
            @this.set('contractData.signed_date', e.target.value);
        });
</script>
