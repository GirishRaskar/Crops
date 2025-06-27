<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Place this in your <head> -->
<link rel="icon" type="image/png" href="<?= base_url('public/logo.png') ?>">

  
  <title>Crop Sowing Progress <?= esc($current_year) ?></title>
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

<!-- Styling for progress bar -->
  <style>
    .progress-agri-striped {
      background-color: #f1f8e9;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: inset 0 1px 2px rgba(0,0,0,0.15);
      position: relative;
    }

    /* Colored bars */
    .bg-agri-brown {
      background: repeating-linear-gradient(
        45deg,
        #795548,
        #795548 10px,
        #8d6e63 10px,
        #8d6e63 20px
      ) !important;
    }


    /* Center the label over the whole bar */
    .progress-label-center {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      font-weight: 600;
      font-size: 0.9rem;
      color: #333;
      display: flex;
      align-items: center;
      justify-content: center;
      pointer-events: none;
      text-shadow: 0 1px 1px rgba(255, 255, 255, 0.8);
    }

    .animate-bar {
      transition: width 3s ease-in-out !important;
    }


  </style>
</head>
<body>
  <div class="container py-4">
    <h2 class="mb-3">🌾 Crop Sowing Progress <?= esc($current_year) ?></h2>
    <p class="text-muted">📅 Last updated: <?= esc($last_updated) ?></p>

    <div class="insight-box">
      <p class="mb-0">
        This dashboard compares sowing progress <strong>as of <?= esc($data_date) ?> </strong>
        with the same period in <strong><?= esc($comparison_year) ?></strong>. Also shows current year's progress relative to the normal sown area.
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
                  <li><strong><?= esc($current_year) ?> (till <?= esc($data_date) ?>):</strong> <?= esc($crop['area']) ?> Lakh ha</li>
                  <li><strong><?= esc($comparison_year) ?> (same period)  :     </strong> <?= esc($crop['last_year']) ?> Lakh ha</li>
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

                <div class="mb-3">
                  <div class="small text-muted mb-1">
                    Current Sowing Progress vs Normal (<strong><?= esc($crop['normal']) ?> Lakh ha</strong>)
                  </div>

                  <div class="progress progress-agri-striped" style="height: 12px;" 
                      title="<?= esc($crop['area']) ?> sown out of <?= esc($crop['normal']) ?> Lakh ha">
                    <div class="progress-bar bg-agri-brown animate-bar"
                      role="progressbar"
                      data-target="<?= esc(min($crop['percentSown'], 100)) ?>"
                      style="width: 0%;"
                      aria-valuenow="<?= esc($crop['percentSown']) ?>"
                      aria-valuemin="0"
                      aria-valuemax="100">
                    </div>
                  </div>

                  <div class="text-center mt-1 small text-muted">
                    <strong><?= esc($crop['percentSown']) ?>%</strong> of normal sown
                  </div>
                </div>


               
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>

    <footer class="footer-note text-center small">
      <hr>
      <div>Data sourced from the <strong>Department of Agriculture and Farmers Welfare</strong>, Government of India.</div>
      <p>This insight compares this year's (2025) sowing progress with the same period last year(2024), based on available government estimates. Intended for advisory and educational purposes.</p>

      <br>
      <p class="mt-2 mb-0">&copy; 2025 Girish Raskar. All rights reserved.</p>
    </footer>
  </div>
</body>
</html>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".animate-bar").forEach(function (bar) {
      const target = parseFloat(bar.getAttribute("data-target")) || 0;
      setTimeout(() => {
        bar.style.width = target + "%";
      }, 200); // slight delay to ensure transition triggers
    });
  });
</script>
