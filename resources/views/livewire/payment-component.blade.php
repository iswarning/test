<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    {{-- Thông tin thanh toán và khách hàng trễ hạn --}}
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8">
                    <h3>Thông tin thanh toán</h3>
                </div>
                @if(Auth::user()->type != 3)
                <div class="col-md-2"></div>
                <div class="col-md-2"><x-jet-button wire:click="updateShowPaymentAndBill({{$payment->id}})"> Sửa </x-jet-button></div>
                @endif
            </div>
        </div>
    
        <div class="card-body">
    
            <div class="row">
                <div class="col-md-1"></div>
                <h5 class="col-md-5"> Tiến độ thanh toán: </h5>
                <div class="col-md-1"></div>
                <label class="col-md-5">{{$payment->payment_progress}}</label>
            </div><hr/>
    
            <div class="row">
                <div class="col-md-1"></div>
                <h5 class="col-md-5"> Ngày thanh toán đủ 95%: </h5>
                <div class="col-md-1"></div>
                <label class="col-md-5">
                    {{ isset($payment->payment_date_95) ? $payment->payment_date_95 : null }}
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
                    <div class="col-md-5"><x-jet-button wire:click="createShowModalBillLate({{$payment->id}})"> {{ __('Thêm thanh toán trễ hạn') }} </x-jet-button></div>
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
</div>
<script>
    // $('#payment_date_95').datepicker();
    // $('#payment_date_95').on('change',function(e){
    //     @this.set('payment_date_95', e.target.value);
    // });

    $('#payment_date_95_2').datepicker();
    $('#payment_date_95_2').on('change',function(e){
        @this.set('paymentData.payment_date_95', e.target.value);
    });
</script>