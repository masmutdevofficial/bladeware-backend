<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
    }

    th {
        background-color: #f2f2f2;
        text-align: left;
        font-size: 16px;
        padding: 10px;
    }

    td {
        padding: 8px 10px;
        font-size: 14px;
    }

    .header-title {
        background-color: #343a40;
        color: white;
        font-size: 18px;
        text-align: center;
        padding: 12px;
    }

    .filter-info {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .currency {
        text-align: right;
    }
</style>

<table border="1">
    <tr>
        <th colspan="2" class="header-title">📊 Dashboard Data Export</th>
    </tr>
    <tr class="filter-info">
        <td>Filter Tanggal</td>
        <td>
            {{ $filter_date ?? '-' }}
        </td>
    </tr>
    <tr>
        <td>Total Users</td>
        <td>{{ $totalUsers }}</td>
    </tr>
    <tr>
        <td>Total Products</td>
        <td>{{ $totalProducts }}</td>
    </tr>
    <tr>
        <td>Total Deposits</td>
        <td class="currency">{{ number_format($totalDeposits, 2, '.', ',') }}</td>
    </tr>
    <tr>
        <td>Total Withdrawals</td>
        <td class="currency">{{ number_format($totalWithdrawals, 2, '.', ',') }}</td>
    </tr>
    <tr>
        <td>Total Transactions</td>
        <td>{{ $totalTransactions }}</td>
    </tr>
</table>
