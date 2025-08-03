<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Utilisateurs - EazyStore</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #667eea;
            font-size: 24px;
            margin: 0 0 10px 0;
        }
        
        .header p {
            color: #666;
            margin: 5px 0;
        }
        
        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #667eea;
        }
        
        .stat-label {
            font-size: 10px;
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th {
            background: #667eea;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .role-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .role-admin {
            background: #ffc107;
            color: #856404;
        }
        
        .role-user {
            background: #28a745;
            color: white;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Liste des Utilisateurs</h1>
        <p><strong>EazyStore</strong> - Gestion des utilisateurs</p>
        <p>Généré le {{ date('d/m/Y à H:i') }}</p>
    </div>

    <div class="stats">
        <div class="stat-item">
            <div class="stat-number">{{ $users->count() }}</div>
            <div class="stat-label">Total Utilisateurs</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $users->where('is_admin', true)->count() }}</div>
            <div class="stat-label">Administrateurs</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $users->where('is_admin', false)->count() }}</div>
            <div class="stat-label">Utilisateurs</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $users->where('email_verified_at', '!=', null)->count() }}</div>
            <div class="stat-label">Emails vérifiés</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Email vérifié</th>
                <th>Date d'inscription</th>
                <th>Commandes</th>
                <th>Total dépensé</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="role-badge {{ $user->is_admin ? 'role-admin' : 'role-user' }}">
                            {{ $user->is_admin ? 'Admin' : 'User' }}
                        </span>
                    </td>
                    <td>{{ $user->email_verified_at ? '✅ Oui' : '❌ Non' }}</td>
                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $user->orders->count() }}</td>
                    <td>{{ number_format($user->orders->sum('total'), 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p><strong>EazyStore</strong> - Rapport généré automatiquement</p>
        <p>Ce document contient des informations confidentielles</p>
    </div>
</body>
</html> 