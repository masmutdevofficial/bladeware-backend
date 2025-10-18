<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Export</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; vertical-align: top; }
        .bg-danger { background-color: #dc3545; color: white; }
        .bg-primary { background-color: #007bff; color: white; }
        .bg-success { background-color: #28a745; color: white; }
        .bg-warning { background-color: #ffc107; color: black; }
    </style>
</head>
<body>
    <h2>User Export</h2>

    <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>User Detail</th>
                <th>Quality Info</th>
                <th>Recharge Info</th>
                <th>Boost Info</th>
                <th>Register Info</th>
                <th>Workdays</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($users as $user)
            <tr>
                <td style="background-color:
                    @if($user->level == 0) #dc3545
                    @elseif($user->level == 1) #007bff
                    @elseif($user->level == 2) #28a745
                    @elseif($user->level == 3) #ffc107
                    @else #f8f9fa @endif;
                    color: #fff;">
                    {{ $no++ }}
                </td>
                <td>
                    Nama: {{ $user->name }}<br>
                    Phone/Email: {{ $user->phone_email }}<br>
                    VIP: {{ $user->membership }}<br>
                    Invitation: {{ $user->referral }}<br>
                    Upline: {{ $user->upline_name ?? '-' }}
                </td>
                <td>
                    Saldo: {{ number_format($user->finance->saldo ?? 0, 2, '.', '') }}<br>
                    Beku: {{ number_format($user->finance->saldo_beku ?? 0, 2, '.', '') }}<br>
                    Komisi Misi: {{ number_format($user->finance->saldo_misi ?? 0, 2, '.', '') }}<br>
                    Komisi Referral: {{ number_format($user->finance->komisi ?? 0, 2, '.', '') }}
                </td>
                <td>
                    Recharge: {{ $user->deposit_count ?? 0 }} times<br>
                    Amount: {{ number_format($user->deposit_total ?? 0, 2, '.', '') }}<br>
                    Withdrawn: {{ $user->withdrawal_count ?? 0 }} times<br>
                    Withdrawn Amt: {{ number_format($user->withdrawal_total ?? 0, 2, '.', '') }}
                </td>
                <td>
                    @if ($user->has_combination)
                        <div>
                            Order Boost: {{ $user->task_done }}/{{ $user->task_limit }}<br>
                            Combination Data:
                            @if (!empty($user->combination_product))
                                {{ implode(', ', array_unique($user->combination_product)) }}<br>
                            @endif
                
                            @if ($user->combination_data)
                                Order: {{ $user->combination_data->sequence + 1 }}<br>
                                Set: {{ $user->combination_data->set_boost }}<br>
                            @endif
                        </div>
                    @else
                        <div>
                            Order Boost: {{ $user->task_done }}/{{ $user->task_limit }}<br>
                            Product ID: {{ $user->latest_product_id ?? '-' }}
                        </div>
                    @endif
                </td>
                <td>
                    Registered: {{ $user->created_at }}<br>
                    Last Update: {{ $user->finance->updated_at ?? '-' }}<br>
                    IP: {{ $user->ip_address ?? '-' }}
                </td>
                <td>
                    @for ($i = 0; $i < 5; $i++)
                            Day {{ $i + 1 }}
                            {{ $user->absen_user[$i]->created_at ?? '-' }}<br>
                    @endfor
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
