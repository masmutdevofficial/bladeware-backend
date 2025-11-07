<table>
    <thead>
        <tr>
            <th>No</th>
            <th>User Detail</th>
            <th>Finance</th>
            <th>Recharge / Withdraw</th>
            <th>Boost</th>
            <th>Register Info</th>
            <th>Workdays</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                Name: {{ $user->name }}<br />
                Phone: {{ $user->phone_email }}<br />
                Email: {{ $user->email_only }}<br />
                VIP: {{ $user->membership }}<br />
                Code: {{ $user->referral }}<br />
                Upline: {{ $user->upline_name ?? '-' }}
            </td>
            <td>
                Available: {{ number_format($user->finance->saldo ?? 0, 2, '.', ',') }}<br />
                Frozen: {{ number_format($user->finance->saldo_beku ?? 0, 2, '.', ',') }}<br />
                Mission: {{ number_format($user->finance->saldo_misi ?? 0, 2, '.', ',') }}<br />
                Commission: {{ number_format($user->finance->komisi ?? 0, 2, '.', ',') }}
            </td>
            <td>
                Recharge: {{ $user->deposit_count }}x<br />
                Amount: {{ number_format($user->deposit_total ?? 0, 2, '.', ',') }}<br />
                Withdraw: {{ $user->withdrawal_count }}x<br />
                Amount: {{ number_format($user->withdrawal_total ?? 0, 2, '.', ',') }}
            </td>
            <td>
                {{ $user->task_done }}/{{ $user->task_limit }}<br />
                @if(!empty($user->combination))
                    @foreach($user->combination as $combo)
                        ID: {{ $combo->id_produk }} | Seq: {{ $combo->sequence }} | Set: {{ $combo->set_boost }}<br />
                    @endforeach
                @else
                    Product ID: {{ $user->latest_product_id ?? '-' }}
                @endif
            </td>
            <td>
                Created: {{ $user->created_at }}<br />
                Updated: {{ $user->finance->updated_at ?? '-' }}<br />
                IP: {{ $user->ip_address ?? '-' }}
            </td>
            <td>
                @foreach($user->absen_user->take(5) as $i => $absen)
                    Day {{ $i + 1 }}: {{ $absen->created_at }}<br />
                @endforeach
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
