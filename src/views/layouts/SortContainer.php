<div class="sort-container row-space-between">
    <div class="sort-origin row-16">
        <a href="/newest/1" class="sort action <?php if ($sort === 'newest'): ?> active <?php endif ?>" data-sort="newest">Mới nhất</a>
        <a href="/oldest/1" class="sort action <?php if ($sort === 'oldest'): ?> active <?php endif ?>" data-sort="oldest">Cũ nhất</a>
        <a href="/popularity/week/1" class="sort action <?php if ($sort === 'popularity'): ?> active <?php endif ?>" data-sort="popularity">Nổi bật</a>
    </div>
    <?php if ($sort === 'popularity'): ?>
        <div class="time-frame row-16">
            <a href="/popularity/week/1" class="sort action <?php if ($timeFrame === 'week'): ?> active <?php endif ?>" data-sort="week">Tuần</a>
            <a href="/popularity/month/1" class="sort action <?php if ($timeFrame === 'month'): ?> active <?php endif ?>" data-sort="month">Tháng</a>
            <a href="/popularity/year/1" class="sort action <?php if ($timeFrame === 'year'): ?> active <?php endif ?>" data-sort="year">Năm</a>
            <a href="/popularity/infinite/1" class="sort action <?php if ($timeFrame === 'infinite'): ?> active <?php endif ?>" data-sort="infinite">Tất cả</a>
        </div>
    <?php endif ?>
</div>