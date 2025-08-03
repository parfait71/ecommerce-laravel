@extends('layouts.admin')

@section('header')
    <div class="analytics-header" data-aos="fade-up">
        <div class="header-content">
            <div class="header-left">
                <h1 class="analytics-title">
                    <i class="fas fa-chart-line me-3"></i>Analytics Avancé
                </h1>
                <p class="analytics-subtitle">Analysez vos performances et optimisez votre business</p>
            </div>
            <div class="header-right">
                <div class="export-buttons">
                    <a href="{{ route('admin.analytics.export.pdf') }}" class="export-btn pdf-btn" title="Télécharger le rapport PDF">
                        <i class="fas fa-file-pdf me-2"></i>PDF
                    </a>
                    <a href="{{ route('admin.analytics.export.excel') }}" class="export-btn excel-btn" title="Télécharger le rapport Excel">
                        <i class="fas fa-file-excel me-2"></i>Excel
                    </a>
                </div>
                <div class="period-selector">
                    <button class="period-btn active" data-period="30">30 jours</button>
                    <button class="period-btn" data-period="90">90 jours</button>
                    <button class="period-btn" data-period="365">1 an</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Métriques principales -->
    <div class="metrics-grid mb-5">
        <div class="metric-card" data-aos="fade-up" data-aos-delay="100">
            <div class="metric-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-value">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} FCFA</h3>
                <p class="metric-label">Chiffre d'affaires total</p>
                <div class="metric-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+15% vs période précédente</span>
                </div>
            </div>
        </div>
        
        <div class="metric-card" data-aos="fade-up" data-aos-delay="200">
            <div class="metric-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-value">{{ $stats['total_orders'] }}</h3>
                <p class="metric-label">Commandes totales</p>
                <div class="metric-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+8% ce mois</span>
                </div>
            </div>
        </div>
        
        <div class="metric-card" data-aos="fade-up" data-aos-delay="300">
            <div class="metric-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-value">{{ $stats['total_users'] }}</h3>
                <p class="metric-label">Utilisateurs actifs</p>
                <div class="metric-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+12% ce mois</span>
                </div>
            </div>
        </div>
        
        <div class="metric-card" data-aos="fade-up" data-aos-delay="400">
            <div class="metric-icon">
                <i class="fas fa-percentage"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-value">{{ $stats['conversion_rate'] }}%</h3>
                <p class="metric-label">Taux de conversion</p>
                <div class="metric-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+2.5% ce mois</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques principaux -->
    <div class="charts-grid mb-5">
        <div class="chart-container" data-aos="fade-up">
            <div class="chart-header">
                <h4 class="chart-title">
                    <i class="fas fa-chart-line me-2"></i>Évolution des ventes
                </h4>
                <div class="chart-actions">
                    <button class="chart-btn active" data-chart="sales" data-period="30">30j</button>
                    <button class="chart-btn" data-chart="sales" data-period="90">90j</button>
                    <button class="chart-btn" data-chart="sales" data-period="365">1an</button>
                </div>
            </div>
            <div class="chart-wrapper">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        
        <div class="chart-container" data-aos="fade-up">
            <div class="chart-header">
                <h4 class="chart-title">
                    <i class="fas fa-chart-pie me-2"></i>Répartition des commandes
                </h4>
            </div>
            <div class="chart-wrapper">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Métriques avancées -->
    <div class="advanced-metrics-grid mb-5">
        <div class="advanced-metric-card" data-aos="fade-up">
            <div class="metric-header">
                <h5 class="metric-title">
                    <i class="fas fa-user-clock me-2"></i>Valeur vie client
                </h5>
            </div>
            <div class="metric-body">
                <h3 class="metric-value">{{ number_format($advancedMetrics['customer_lifetime_value'], 0, ',', ' ') }} FCFA</h3>
                <p class="metric-description">Valeur moyenne par client sur sa durée de vie</p>
            </div>
        </div>
        
        <div class="advanced-metric-card" data-aos="fade-up">
            <div class="metric-header">
                <h5 class="metric-title">
                    <i class="fas fa-redo me-2"></i>Taux de clients récurrents
                </h5>
            </div>
            <div class="metric-body">
                <h3 class="metric-value">{{ $advancedMetrics['repeat_customer_rate'] }}%</h3>
                <p class="metric-description">Pourcentage de clients ayant commandé plusieurs fois</p>
            </div>
        </div>
        
        <div class="advanced-metric-card" data-aos="fade-up">
            <div class="metric-header">
                <h5 class="metric-title">
                    <i class="fas fa-clock me-2"></i>Temps moyen d'achat
                </h5>
            </div>
            <div class="metric-body">
                <h3 class="metric-value">{{ $advancedMetrics['average_time_to_purchase'] }} min</h3>
                <p class="metric-description">Temps moyen entre la visite et l'achat</p>
            </div>
        </div>
        
        <div class="advanced-metric-card" data-aos="fade-up">
            <div class="metric-header">
                <h5 class="metric-title">
                    <i class="fas fa-map-marker-alt me-2"></i>Distribution géographique
                </h5>
            </div>
            <div class="metric-body">
                <div class="geo-distribution">
                    @foreach($advancedMetrics['geographic_distribution'] as $geo)
                        <div class="geo-item">
                            <span class="geo-region">{{ $geo['region'] }}</span>
                            <span class="geo-orders">{{ $geo['orders'] }} commandes</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques secondaires -->
    <div class="secondary-charts-grid mb-5">
        <div class="chart-container" data-aos="fade-up">
            <div class="chart-header">
                <h4 class="chart-title">
                    <i class="fas fa-chart-bar me-2"></i>Performance par catégorie
                </h4>
            </div>
            <div class="chart-wrapper">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
        
        <div class="chart-container" data-aos="fade-up">
            <div class="chart-header">
                <h4 class="chart-title">
                    <i class="fas fa-clock me-2"></i>Heures de pointe
                </h4>
            </div>
            <div class="chart-wrapper">
                <canvas id="hoursChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top produits et insights -->
    <div class="insights-grid mb-5">
        <div class="insight-card" data-aos="fade-up">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fas fa-star me-2"></i>Top Produits
                </h4>
                <a href="{{ route('admin.products.index') }}" class="view-all">Voir tout</a>
            </div>
            <div class="products-list">
                @forelse($chartData['top_products']->take(5) as $index => $product)
                    <div class="product-item">
                        <div class="product-rank">
                            <span class="rank-number">{{ $index + 1 }}</span>
                        </div>
                        <div class="product-info">
                            <h6 class="product-name">{{ $product->name }}</h6>
                            <span class="product-category">{{ $product->category->name ?? 'Sans catégorie' }}</span>
                        </div>
                        <div class="product-stats">
                            <span class="product-sales">{{ $product->total_sold ?? 0 }} vendus</span>
                            <span class="product-revenue">{{ number_format($product->revenue ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h5 class="empty-title">Aucune vente enregistrée</h5>
                        <p class="empty-description">Les produits les plus vendus apparaîtront ici</p>
                    </div>
                @endforelse
            </div>
        </div>
        
        <div class="insight-card" data-aos="fade-up">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fas fa-lightbulb me-2"></i>Insights & Recommandations
                </h4>
            </div>
            <div class="insights-list">
                <div class="insight-item positive">
                    <div class="insight-icon">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <div class="insight-content">
                        <h6 class="insight-title">Croissance des ventes</h6>
                        <p class="insight-description">Vos ventes ont augmenté de 15% ce mois</p>
                    </div>
                </div>
                
                <div class="insight-item warning">
                    <div class="insight-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="insight-content">
                        <h6 class="insight-title">Stock faible</h6>
                        <p class="insight-description">3 produits ont un stock inférieur à 10 unités</p>
                    </div>
                </div>
                
                <div class="insight-item info">
                    <div class="insight-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="insight-content">
                        <h6 class="insight-title">Heure de pointe</h6>
                        <p class="insight-description">14h-16h est votre créneau le plus actif</p>
                    </div>
                </div>
                
                <div class="insight-item success">
                    <div class="insight-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="insight-content">
                        <h6 class="insight-title">Clients fidèles</h6>
                        <p class="insight-description">25% de vos clients sont récurrents</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="quick-actions-section">
        <div class="section-header" data-aos="fade-up">
            <h3 class="section-title">
                <i class="fas fa-bolt me-2"></i>Actions rapides
            </h3>
        </div>
        
        <div class="actions-grid">
            <div class="action-card" data-aos="zoom-in" data-aos-delay="100">
                <div class="action-icon">
                    <i class="fas fa-download"></i>
                </div>
                <div class="action-content">
                    <h5 class="action-title">Exporter les données</h5>
                    <p class="action-description">Téléchargez vos analytics en CSV/JSON</p>
                    <button class="action-btn" onclick="exportData('csv')">
                        <i class="fas fa-file-csv me-2"></i>CSV
                    </button>
                    <button class="action-btn" onclick="exportData('json')">
                        <i class="fas fa-file-code me-2"></i>JSON
                    </button>
                </div>
            </div>
            
            <div class="action-card" data-aos="zoom-in" data-aos-delay="200">
                <div class="action-icon">
                    <i class="fas fa-chart-area"></i>
                </div>
                <div class="action-content">
                    <h5 class="action-title">Rapport détaillé</h5>
                    <p class="action-description">Générez un rapport complet</p>
                    <button class="action-btn" onclick="generateReport()">
                        <i class="fas fa-file-pdf me-2"></i>Générer
                    </button>
                </div>
            </div>
            
            <div class="action-card" data-aos="zoom-in" data-aos-delay="300">
                <div class="action-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="action-content">
                    <h5 class="action-title">Alertes</h5>
                    <p class="action-description">Configurez vos notifications</p>
                    <button class="action-btn" onclick="configureAlerts()">
                        <i class="fas fa-cog me-2"></i>Configurer
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Données des graphiques
    const chartData = @json($chartData);
    const advancedMetrics = @json($advancedMetrics);
    
    // Graphique des ventes
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesGradient = salesCtx.createLinearGradient(0, 0, 0, 400);
    salesGradient.addColorStop(0, 'rgba(102, 126, 234, 0.3)');
    salesGradient.addColorStop(1, 'rgba(102, 126, 234, 0.0)');
    
    const salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: chartData.sales_trend.map(item => item.date),
            datasets: [{
                label: 'Ventes (FCFA)',
                data: chartData.sales_trend.map(item => item.revenue),
                borderColor: '#667eea',
                backgroundColor: salesGradient,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6c757d',
                        font: { size: 12 }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(108, 117, 125, 0.1)'
                    },
                    ticks: {
                        color: '#6c757d',
                        font: { size: 12 },
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR').format(value) + ' FCFA';
                        }
                    }
                }
            }
        }
    });
    
    // Graphique des commandes (pie chart)
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    const orderStatusData = @json($chartData['order_status_distribution']);
    
    const ordersChart = new Chart(ordersCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(orderStatusData),
            datasets: [{
                data: Object.values(orderStatusData),
                backgroundColor: [
                    '#28a745',
                    '#ffc107',
                    '#dc3545',
                    '#17a2b8'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#6c757d',
                        font: { size: 12 }
                    }
                }
            }
        }
    });
    
    // Graphique des catégories
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryData = @json($chartData['category_performance']);
    
    const categoryChart = new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: categoryData.map(item => item.name),
            datasets: [{
                label: 'Revenus (FCFA)',
                data: categoryData.map(item => item.total_revenue || 0),
                backgroundColor: '#667eea',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6c757d',
                        font: { size: 12 }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(108, 117, 125, 0.1)'
                    },
                    ticks: {
                        color: '#6c757d',
                        font: { size: 12 },
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR').format(value) + ' FCFA';
                        }
                    }
                }
            }
        }
    });
    
    // Graphique des heures
    const hoursCtx = document.getElementById('hoursChart').getContext('2d');
    const hoursData = @json($advancedMetrics['top_performing_hours']);
    
    const hoursChart = new Chart(hoursCtx, {
        type: 'bar',
        data: {
            labels: hoursData.map(item => item.hour + 'h'),
            datasets: [{
                label: 'Commandes',
                data: hoursData.map(item => item.orders),
                backgroundColor: '#764ba2',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6c757d',
                        font: { size: 12 }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(108, 117, 125, 0.1)'
                    },
                    ticks: {
                        color: '#6c757d',
                        font: { size: 12 }
                    }
                }
            }
        }
    });
    
    // Gestion des boutons de période
    const periodBtns = document.querySelectorAll('.period-btn');
    periodBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            periodBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const period = this.dataset.period;
            console.log('Période sélectionnée:', period);
            // Ici vous pouvez mettre à jour les données selon la période
        });
    });
});

// Fonctions d'export
function exportData(format) {
    fetch(`/admin/analytics/export?format=${format}`)
        .then(response => {
            if (format === 'csv') {
                return response.blob();
            }
            return response.json();
        })
        .then(data => {
            if (format === 'csv') {
                const url = window.URL.createObjectURL(data);
                const a = document.createElement('a');
                a.href = url;
                a.download = `analytics.${format}`;
                a.click();
            } else {
                const dataStr = JSON.stringify(data, null, 2);
                const dataBlob = new Blob([dataStr], {type: 'application/json'});
                const url = window.URL.createObjectURL(dataBlob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `analytics.${format}`;
                a.click();
            }
        })
        .catch(error => {
            console.error('Erreur lors de l\'export:', error);
            alert('Erreur lors de l\'export des données');
        });
}

function generateReport() {
    alert('Génération du rapport en cours...');
    // Ici vous pouvez implémenter la génération de rapport PDF
}

function configureAlerts() {
    alert('Configuration des alertes...');
    // Ici vous pouvez implémenter la configuration des alertes
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debug des boutons d'export
    const pdfBtn = document.querySelector('.pdf-btn');
    const excelBtn = document.querySelector('.excel-btn');
    
    if (pdfBtn) {
        console.log('Bouton PDF trouvé:', pdfBtn.href);
        pdfBtn.addEventListener('click', function(e) {
            console.log('Clic sur PDF détecté');
            // Ne pas empêcher le comportement par défaut
        });
    } else {
        console.log('Bouton PDF non trouvé');
    }
    
    if (excelBtn) {
        console.log('Bouton Excel trouvé:', excelBtn.href);
        excelBtn.addEventListener('click', function(e) {
            console.log('Clic sur Excel détecté');
            // Ne pas empêcher le comportement par défaut
        });
    } else {
        console.log('Bouton Excel non trouvé');
    }
});
</script>
@endpush

<style>
/* Header Analytics */
.analytics-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.analytics-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: white;
}

.analytics-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 0;
    color: rgba(255, 255, 255, 0.9);
}

.export-buttons {
    display: flex;
    gap: 0.5rem;
    margin-right: 1rem;
}

.export-btn {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    font-size: 0.9rem;
}

.export-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.pdf-btn {
    background: linear-gradient(135deg, #dc3545, #c82333);
    border-color: #dc3545;
}

.pdf-btn:hover {
    background: linear-gradient(135deg, #c82333, #bd2130);
    border-color: #c82333;
}

.excel-btn {
    background: linear-gradient(135deg, #28a745, #218838);
    border-color: #28a745;
}

.excel-btn:hover {
    background: linear-gradient(135deg, #218838, #1e7e34);
    border-color: #218838;
}

.period-selector {
    display: flex;
    gap: 0.5rem;
}

.period-btn {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.period-btn:hover,
.period-btn.active {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
}

/* Grille de métriques */
.metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.metric-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.metric-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 16px 16px 0 0;
}

.metric-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.metric-icon {
    font-size: 2.2rem;
    color: #667eea;
    margin-bottom: 1rem;
}

.metric-content {
    z-index: 2;
    position: relative;
}

.metric-value {
    font-size: 2.1rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.metric-label {
    font-size: 1rem;
    color: #495057;
    margin-bottom: 0.5rem;
}

.metric-trend {
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.metric-trend.positive {
    color: #28a745;
}

/* Grille de graphiques */
.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.chart-container {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.chart-container:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.chart-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
}

.chart-actions {
    display: flex;
    gap: 0.5rem;
}

.chart-btn {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    color: #495057;
    padding: 0.3rem 0.8rem;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.chart-btn:hover,
.chart-btn.active {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.chart-wrapper {
    height: 300px;
    position: relative;
}

/* Métriques avancées */
.advanced-metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.advanced-metric-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.advanced-metric-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.metric-header {
    margin-bottom: 1rem;
}

.metric-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
}

.metric-body {
    text-align: center;
}

.metric-value {
    font-size: 2rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 0.5rem;
}

.metric-description {
    color: #495057;
    font-size: 0.95rem;
    margin: 0;
}

.geo-distribution {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.geo-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.geo-region {
    font-weight: 600;
    color: #2c3e50;
}

.geo-orders {
    color: #495057;
    font-size: 0.9rem;
}

/* Graphiques secondaires */
.secondary-charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

/* Insights */
.insights-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.insight-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.insight-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.card-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
}

.view-all {
    color: #667eea;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s;
}

.view-all:hover {
    color: #764ba2;
}

.products-list {
    display: flex;
    flex-direction: column;
    gap: 0.7rem;
}

.product-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.7rem;
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.product-item:hover {
    background: #e9ecef;
}

.product-rank {
    width: 30px;
    height: 30px;
    background: #667eea;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
}

.product-info {
    flex: 1;
}

.product-name {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.2rem;
}

.product-category {
    font-size: 0.9rem;
    color: #495057;
}

.product-stats {
    text-align: right;
}

.product-sales {
    display: block;
    font-size: 0.9rem;
    color: #495057;
}

.product-revenue {
    display: block;
    font-weight: 700;
    color: #28a745;
}

.insights-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.insight-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.insight-item.positive {
    background: rgba(40, 167, 69, 0.1);
    border-left: 4px solid #28a745;
}

.insight-item.warning {
    background: rgba(255, 193, 7, 0.1);
    border-left: 4px solid #ffc107;
}

.insight-item.info {
    background: rgba(23, 162, 184, 0.1);
    border-left: 4px solid #17a2b8;
}

.insight-item.success {
    background: rgba(40, 167, 69, 0.1);
    border-left: 4px solid #28a745;
}

.insight-icon {
    font-size: 1.2rem;
}

.insight-item.positive .insight-icon {
    color: #28a745;
}

.insight-item.warning .insight-icon {
    color: #ffc107;
}

.insight-item.info .insight-icon {
    color: #17a2b8;
}

.insight-item.success .insight-icon {
    color: #28a745;
}

.insight-content {
    flex: 1;
}

.insight-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.2rem;
}

.insight-description {
    color: #495057;
    font-size: 0.95rem;
    margin: 0;
}

/* Actions rapides */
.quick-actions-section {
    background: none;
    box-shadow: none;
    border: none;
}

.section-header {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.action-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
}

.action-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.action-icon {
    font-size: 2rem;
    color: #667eea;
    background: #f3f0fa;
    border-radius: 50%;
    padding: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
}

.action-description {
    color: #495057;
    font-size: 0.95rem;
    margin: 0;
}

.action-btn {
    background: #667eea;
    color: white;
    border: none;
    border-radius: 10px;
    padding: 0.5rem 1rem;
    font-weight: 600;
    transition: background 0.2s;
    cursor: pointer;
    margin-right: 0.5rem;
}

.action-btn:hover {
    background: #764ba2;
}

/* États vides */
.empty-state {
    text-align: center;
    padding: 2rem 1rem;
    color: #adb5bd;
}

.empty-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #dee2e6;
}

.empty-title {
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.empty-description {
    color: #adb5bd;
    font-size: 0.95rem;
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1.5rem;
    }
    
    .metrics-grid,
    .charts-grid,
    .advanced-metrics-grid,
    .secondary-charts-grid,
    .insights-grid,
    .actions-grid {
        grid-template-columns: 1fr;
    }
    
    .chart-wrapper {
        height: 250px;
    }
}

/* Forcer les couleurs claires */
.metric-card,
.chart-container,
.advanced-metric-card,
.insight-card,
.action-card,
.section-header {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%) !important;
    color: #2c3e50 !important;
    border: 1px solid #e9ecef !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
}

.metric-card *,
.chart-container *,
.advanced-metric-card *,
.insight-card *,
.action-card *,
.section-header * {
    color: inherit !important;
}
</style> 