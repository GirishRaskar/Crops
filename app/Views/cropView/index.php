<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kharif <?= esc($current_year) ?> Crop Comparison</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom right, #f5fff0, #e1f5dc);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    h2 {
      font-weight: 700;
      color: #2f5e1d;
    }
    .section-title {
      font-size: 1.3rem;
      font-weight: 600;
      margin-top: 2rem;
      color: #3e6b2f;
      border-left: 6px solid #7bb661;
      padding-left: 10px;
    }
    .card-custom {
      border: 1px solid #cde0b7;
      border-radius: 12px;
      background-color: #ffffff;
      transition: box-shadow 0.2s ease;
    }
    .card-custom:hover {
      box-shadow: 0 6px 16px rgba(120, 180, 100, 0.2);
    }
    .trend-up {
      color: #388e3c;
      font-weight: 600;
    }
    .trend-down {
      color: #d32f2f;
      font-weight: 600;
    }
    .trend-neutral {
      color: #6c757d;
      font-weight: 600;
    }
    .percent-badge {
      font-size: 0.85rem;
      padding: 2px 8px;
      border-radius: 12px;
      background-color: #f1f8e9;
      border: 1px solid #aed581;
      margin-left: 8px;
    }
    .insight-box {
      background-color: #f5fff0;
      border-left: 6px solid #689f38;
      padding: 1rem 1.25rem;
      border-radius: 10px;
      margin-bottom: 1.5rem;
    }
    .footer-note {
      padding-top: 3rem;
      color: #556b2f;
    }
    .card-title {
      color: #33691e;
    }
  </style>
</head>
<body>
  <div class="container py-4">
    <h2 class="mb-3">🌾 Kharif <?= esc($current_year) ?> Crop Comparison</h2>
    <p class="text-muted">📅 Last updated: <?= esc($last_updated) ?></p>

    <div class="insight-box">
      <p class="mb-0">
        This dashboard compares sowing progress <strong>as of <?= esc($last_updated) ?> in <?= esc($current_year) ?></strong>
        with the same date in <strong><?= esc($comparison_year) ?></strong>. Green means more area sown than last year, red means less.
      </p>
    </div>

    <?php foreach ($crops as $category => $cropList): ?>
      <div class="section-title">🌿 <?= esc($category) ?></div>
      <div class="row">
        <?php foreach ($cropList as $crop): ?>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="card card-custom h-100">
              <div class="card-body">
                <h5 class="card-title">🌱 <?= esc($crop['name']) ?></h5>
                <ul class="list-unstyled mb-3">
                  <li><strong><?= esc($current_year) ?> (till <?= esc($last_updated) ?>):</strong> <?= esc($crop['area']) ?> Lakh ha</li>
                  <li><strong><?= esc($comparison_year) ?> (till <?= esc($comparison_date) ?>):</strong> <?= esc($crop['last_year']) ?> Lakh ha</li>
                  <li>
                    <strong>Change:</strong>
                    <?php if ($crop['diff'] > 0): ?>
                      <span class="trend-up">+<?= esc($crop['diff']) ?> Lakh ha ↑</span>
                    <?php elseif ($crop['diff'] < 0): ?>
                      <span class="trend-down"><?= esc($crop['diff']) ?> Lakh ha ↓</span>
                    <?php else: ?>
                      <span class="trend-neutral">No change</span>
                    <?php endif; ?>
                    <?php $badgeColor = $crop['percent_change'] < 0 ? 'text-danger' : 'text-success'; ?>
                    <span class="percent-badge <?= $badgeColor ?> fw-semibold">
                    <?= esc($crop['percent_change']) ?>%
                    </span>

                  </li>
                </ul>
                <!-- <p class="small text-muted mb-0">💡 <?= esc($crop['advice']) ?></p> -->
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>

    <footer class="footer-note text-center small">
      <hr>
      <p>This insight compares year-on-year sowing progress to guide crop choices and market expectations.</p>
      <br>
      <p class="mt-2">&copy; <?= date('Y') ?> <?= esc($app_owner ?? 'Your Name or Startup') ?>. All rights reserved.</p>
    </footer>
  </div>
</body>
</html>
