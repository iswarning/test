<html>
    <head>
        <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1252">
            <META HTTP-EQUIV="Content-language" CONTENT="vi">
      <title>Export Customers List To PDF File</title>
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Pridi:wght@200&display=swap" rel="stylesheet">
      <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
      <style>
          .customers {
    font-family: 'Noto Sans', serif;
  border-collapse: collapse;
  font-size: 16px;
  width: 80%;
}
   .customers td, .customers th {
  border: 1px solid #ddd;
  padding: 8px;
}
   h2{
       text-align:center;
   }
   tr:first-child{
       font-size: 20px !important;
       color: white;
       background-color: green;
   }


      </style>
    </head>
    <body>
        <div>
            <table class='customers'>
                <tbody>
                    <tr>
                        <td colspan='2' style='text-align: center;'>Thông tin khách hàng</td>
                    </tr>
                    <tr>
                        <td># </td>
                        <td>{{ $customerData->id }}</td>
                    </tr>
                    <tr>
                        <td>Tên: </td>
                        <td>{{ $customerData->name }}</td>
                    </tr>
                    <tr>
                        <td>Cmnd: </td>
                        <td>{{ $customerData->cmnd }}</td>
                    </tr>
                    <tr>
                        <td>Số điện thoại: </td>
                        <td>{{ $customerData->phone }}</td>
                    </tr>
                    <tr>
                        <td>Địa chỉ: </td>
                        <td>{{ $customerData->address }}</td>
                    </tr>
                    <tr>
                        <td>Hộ Khẩu: </td>
                        <td>{{ $customerData->household }}</td>
                    </tr>
                </tbody>
            </table>
<p></p>
<br>
            <table class='customers'>
                <tbody>
                    <tr>
                        <td colspan='2' style='text-align: center;'>Thông tin hợp đồng</td>
                    </tr>
                    <tr>
                        <td># </td>
                        <td>{{ $contractData->id }}</td>
                    </tr>
                    <tr>
                        <td>Số hợp đồng: </td>
                        <td>{{ $contractData->contract_no }}</td>
                    </tr>
                    <tr>
                        <td>Diện tích kí: </td>
                        <td>{{ $contractData->area_signed }}</td>
                    </tr>
                    <tr>
                        <td>Loại hợp đồng: </td>
                        <td>{{ $contractData->type }}</td>
                    </tr>
                    <tr>
                        <td>Đã kí hay chưa: </td>
                        <td>{{ $contractData->signed == 1 ? 'Đã ký' : 'Chưa ký' }}</td>
                    </tr>
                    <tr>
                        <td>Ngày kí: </td>
                        <td>{{ $contractData->signed_date }}</td>
                    </tr>
                    <tr>
                        <td>Giá bán: </td>
                        <td>{{ number_format($contractData->value) }}</td>
                    </tr>
                    <tr>
                        <td>Mã lô: </td>
                        <td>{{ $contractData->lot_number }}</td>
                    </tr>
                    <tr>
                        <td>Dự án: </td>
                        <td>{{ App\Models\Project::find($contractData->project_id)->name }}</td>
                    </tr>
                    <tr>
                        <td>Trạng thái hợp đồng: </td>
                        <td>{{ App\Enums\ContractStatus::statusName[$contractData->status] }}</td>
                    </tr>
                    @if($contractData->status == 2)
                    <tr>
                        <td>Giữ chỗ: </td>
                        <td>{{ App\Enums\ContractStatusCreated::statusName[$contractData->status_created_by] ?? '' }}</td>
                    </tr>
                    @endif
                    


                </tbody>
            </table>
            <p></p>
            <br>
            <table class='customers'>
               <tbody> 
                   <tr>
                    <td colspan='2' style='text-align: center;'>Thông tin thanh toán</td>
                </tr>
                
                    <tr>
                        <td>Tiến độ thanh toán: </td>
                        <td>{{ $paymentData->payment_progress }}</td>
                    </tr>
                    <tr>
                        <td>Ngày thanh toán đủ 95%: </td>
                        <td>{{ $paymentData->payment_date_95 ?? null }}</td>
                    </tr>

                    @if($billlateData != null)
                    <tr>
                        <td>Ngày trễ: </td>
                        <td>{{ $billlateData->day_late }}</td>
                    </tr>
                    <tr>
                        <td>Đợt trễ: </td>
                        <td>{{ $billlateData->batch_late }}</td>
                    </tr>
                    <tr>
                        <td>Số tiền trễ: </td>
                        <td>{{ $billlateData->money_late }}</td>
                    </tr>
                    <tr>
                        <td>Lãi phạt: </td>
                        <td>{{ $billlateData->citation_rate }}</td>
                    </tr>

                    <tr>
                        <td>Số lần đã gửi thông báo: </td>
                        <td>{{ $billlateData->number_notifi }}</td>
                    </tr>
                    <tr>
                        <td>Văn bản, phương thức: </td>
                        <td>{{ $billlateData->document }}</td>
                    </tr>
                    <tr>
                        <td>Ngày khách nhận thông báo: </td>
                        <td>{{ $billlateData->receipt_date }}</td>
                    </tr>

                    @endif
                </tbody>
            </table>
            <p></p>
            <br>
            @if($juridicalData != null)
            <table class='customers'>
                <tbody>
                    <tr>
                        <td colspan='2' style='text-align: center;'>Thông tin thanh toán</td>
                    </tr>
                    <tr>
                        <td>Thông tin hợp đồng: </td>
                        <td>{{ $juridicalData->contract_info }}</td>
                    </tr>
                    <tr>
                        <td>Tình trạng sổ: </td>
                        <td>{{ $juridicalData->status }}</td>
                    </tr>
                    <tr>
                        <td>Ngày công chứng: </td>
                        <td>{{ $juridicalData->notarized_date ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Thủ tục đăng bộ: </td>
                        <td>{{ $juridicalData->registration_procedures }}</td>
                    </tr>
                    <tr>
                        <td>Ngày bàn giao sổ: </td>
                        <td>{{ $juridicalData->delivery_book_date ?? ''  }}</td>
                    </tr>
                    <tr>
                        <td>Thanh lý hợp đồng: </td>
                        <td>{{ $juridicalData->liquidation }}</td>
                    </tr>
                    <tr>
                        <td>Bộ phận giữ sổ: </td>
                        <td>{{ $juridicalData->book_holder }}</td>
                    </tr>
                    <tr>
                        <td>Hồ sơ thu lai của khách hàng: </td>
                        <td>{{ $juridicalData->bill_profile ?? ''}}</td>
                    </tr>
                    <tr>
                        <td>Ngày bàn giao đất: </td>
                        <td>{{ $juridicalData->delivery_land_date ?? ''  }}</td>
                    </tr>
                    <tr>
                        <td>Cam kết thỏa thuận: </td>
                        <td>{{ $juridicalData->commitment ?? ''}}</td>
                    </tr>
                </tbody>
            </table>
            @endif
            
        </div>
    </body>
</html>