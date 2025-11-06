<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Water Bill Calculator</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f7f9fb; padding: 40px; }
    .container { background: white; padding: 30px; border-radius: 10px; width: 420px; margin: auto; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
    h2 { text-align: center; color: #333; }
    label { font-weight: bold; color: #444; display: block; margin-top: 10px; }
    input, button { width: 100%; padding: 10px; margin-top: 6px; border-radius: 6px; border: 1px solid #ccc; font-size: 15px; }
    button { background: #007bff; color: white; font-weight: bold; cursor: pointer; margin-top: 15px; }
    button:hover { background: #0056b3; }
    .result { background: #e9f7ef; padding: 15px; border-radius: 8px; margin-top: 20px; border: 1px solid #c8e6c9; }
    .result h3 { color: #2e7d32; text-align: center; }
    .result table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .result td { padding: 5px; border-bottom: 1px solid #ddd; }
    .result td:first-child { font-weight: bold; }
  </style>
</head>
<body>
  <div class="container">
    <h2>💧 Water Bill Calculator</h2>
    <form method="post">
      <label>Old Reading (m³):</label>
      <input type="number" step="0.001" name="old_reading" required 
             value="<?php echo isset($_POST['old_reading']) ? htmlspecialchars($_POST['old_reading']) : ''; ?>">

      <label>New Reading (m³):</label>
      <input type="number" step="0.001" name="new_reading" required 
             value="<?php echo isset($_POST['new_reading']) ? htmlspecialchars($_POST['new_reading']) : ''; ?>">

      <button type="submit" name="calculate">Calculate</button>
    </form>

    <?php
    if (isset($_POST['calculate'])) {
        $old = floatval($_POST['old_reading']);
        $new = floatval($_POST['new_reading']);
        $consumption = $new - $old;
        $fee = 8.000; // fixed fee

        if ($consumption <= 0) {
            echo "<div class='result'><h3>⚠️ Invalid readings!</h3></div>";
            exit;
        }

        // Determine rate by consumption range
        if ($consumption <= 6) {
            $rate = 2.370;
        } elseif ($consumption <= 12) {
            $rate = 7.390;
        } elseif ($consumption <= 20) {
            $rate = 7.390;
        } elseif ($consumption <= 35) {
            $rate = 10.980;
        } else {
            $rate = 11.020;
        }

        $subtotal = $consumption * $rate;
        $total = $subtotal + $fee;

        echo "<div class='result'>
              <h3>Water Bill Summary</h3>
              <table>
                <tr><td>Old Reading:</td><td>" . number_format($old, 3) . " m³</td></tr>
                <tr><td>New Reading:</td><td>" . number_format($new, 3) . " m³</td></tr>
                <tr><td>Consumption:</td><td>" . number_format($consumption, 3) . " m³</td></tr>
                <tr><td>Rate Applied:</td><td>" . number_format($rate, 3) . " DH/m³</td></tr>
                <tr><td>Subtotal:</td><td>" . number_format($subtotal, 3) . " DH</td></tr>
                <tr><td>Fixed Fee:</td><td>" . number_format($fee, 2) . " DH</td></tr>
                <tr><td><b>Total Bill:</b></td><td><b>" . number_format($total, 2) . " DH</b></td></tr>
              </table>
              </div>";
    }
    ?>
  </div>
</body>
</html>
