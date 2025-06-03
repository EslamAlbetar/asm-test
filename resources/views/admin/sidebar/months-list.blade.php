<div id="monthsContainer">
                <div class="resources-container d-flex flex-wrap justify-content-center gap-4">
                    @foreach($months as $month)
                        <div class="resource-card blue">
                            <div class="resource-header">
                                <div class="resource-title">{{ $month['month'] }} {{ $month['year'] }}</div>
                                <div class="resource-count">{{ $month['days_count'] }} يوم</div>
                                <div class="count-money text-{{ $month['net_profit'] >= 0 ? 'success' : 'danger' }}">
                                    {{ number_format($month['net_profit'], 2) }} EGP
                                </div>
                            </div>

                            <div class="resource-body">
                                <div class="items">
                                    <h6 class="item-name">PDF</h6>
                                    <h6 class="item-name">(الاجمالي)</h6>
                                    <h6 class="item-name">(المخرجات)</h6>
                                    <h6 class="item-name">(المدخلات)</h6>
                                    <h6 class="item-value">التاريخ</h6>
                                    <h6 class="item-value">اليوم</h6>
                                </div>

                                @foreach($month['days'] as $day)
                                <div class="resource-item" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                    <span class="item-value text-success">
                                        <a href="{{ route('export.pdf', ['date' => $day['date']]) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i> PDF
                                        </a>
                                    </span>
                                    <span class="item-value text-{{ $day['net_profit'] >= 0 ? 'success' : 'danger' }}">
                                        {{ number_format($day['net_profit'], 2) }}
                                    </span>
                                    <span class="item-value text-danger">
                                        {{ number_format($day['payments'], 2) }}
                                    </span>
                                    <span class="item-value text-success">
                                        {{ number_format($day['inputs'], 2) }}
                                    </span>
                                    <span class="item-value text-primary">
                                        {{ $day['date'] }}
                                    </span>
                                    <span class="item-name">{{ $day['day_name'] }}</span>
                                </div>
                                @endforeach
                            </div>

                            <a href="{{ route('export.monthly.pdf', ['month' => $month['month_number'], 'year' => $month['year']]) }}" class="view-all-btn">
                                طباعة تقرير شهري
                            </a>
                        </div>
                    @endforeach
                </div>