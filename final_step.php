<?php
// ===============================
// final_step.php
// INCLUDE SAFE VERSION
// ===============================

$data = [
    'property_type'      => $_POST['property_type'] ?? 'Орон сууц',
    'property_name'      => $_POST['property_name'] ?? '3 өрөө орон сууц',
    'address'            => $_POST['address'] ?? 'УБ хот, Хан-Уул дүүрэг, 18-р хороо',
    'purpose'            => $_POST['purpose'] ?? 'Зах зээлийн үнэ цэнэ',
    'valuation_date'     => $_POST['valuation_date'] ?? date('Y-m-d'),
    'area'               => $_POST['area'] ?? 82.5,
    'floor'              => $_POST['floor'] ?? 7,
    'total_floors'       => $_POST['total_floors'] ?? 12,
    'year_built'         => $_POST['year_built'] ?? 2018,

    'cost_value'         => $_POST['cost_value'] ?? 285000000,
    'income_value'       => $_POST['income_value'] ?? 298000000,
    'market_value'       => $_POST['market_value'] ?? 305000000,

    'weight_cost'        => $_POST['weight_cost'] ?? 0,
    'weight_income'      => $_POST['weight_income'] ?? 0,
    'weight_market'      => $_POST['weight_market'] ?? 100,

    'comment'            => $_POST['final_comment'] ?? 'Зах зээлийн хандлагын үр дүнг голлон харгалзан, өртгийн болон орлогын хандлагын үр дүнгээр дэмжиж эцсийн үнэлгээг тогтоов.',
    'special_condition'  => $_POST['special_condition'] ?? 'Объектын дотоод засал, байршил, орчны нөхцөлийг харгалзан үзэв.',
];

if (!function_exists('final_num')) {
    function final_num($v){
        $v = str_replace(',', '', (string)$v);
        return is_numeric($v) ? (float)$v : 0;
    }
}

if (!function_exists('final_fmt')) {
    function final_fmt($v, $decimals = 0){
        return number_format((float)$v, $decimals, '.', ',');
    }
}

$costValue   = final_num($data['cost_value']);
$incomeValue = final_num($data['income_value']);
$marketValue = final_num($data['market_value']);

$wCost   = final_num($data['weight_cost']);
$wIncome = final_num($data['weight_income']);
$wMarket = final_num($data['weight_market']);

$totalWeight = $wCost + $wIncome + $wMarket;

$weightedValue = 0;
if ($totalWeight > 0) {
    $weightedValue = (
        ($costValue * $wCost) +
        ($incomeValue * $wIncome) +
        ($marketValue * $wMarket)
    ) / $totalWeight;
}

$roundedValue = round($weightedValue / 10000) * 10000;
$area = final_num($data['area']);
$pricePerSqm = $area > 0 ? $roundedValue / $area : 0;

$values = array_filter([$costValue, $incomeValue, $marketValue], fn($x) => $x > 0);
$minValue = !empty($values) ? min($values) : 0;
$maxValue = !empty($values) ? max($values) : 0;
$variancePercent = ($minValue > 0) ? (($maxValue - $minValue) / $minValue) * 100 : 0;

$ready = ($totalWeight == 100 && $roundedValue > 0 && $area > 0);
?>

<div class="final-step-wrap">
    <div class="final-wrap">

        <div class="final-title">
            <h2>Эцсийн дүгнэлт</h2>
            <div class="final-step-badge">FINAL STEP</div>
        </div>

        <!-- 1 -->
        <div class="final-section">
            <div class="final-section-title">1. Объектын хураангуй мэдээлэл</div>

            <table class="final-table final-summary-table">
                <tr>
                    <td class="label">Хөрөнгийн төрөл</td>
                    <td class="value-text"><?= htmlspecialchars($data['property_type']) ?></td>

                    <td class="label">Объектын нэр</td>
                    <td class="value-text"><?= htmlspecialchars($data['property_name']) ?></td>
                </tr>

                <tr>
                    <td class="label">Хаяг / Байршил</td>
                    <td class="value-text" colspan="3"><?= htmlspecialchars($data['address']) ?></td>
                </tr>

                <tr>
                    <td class="label">Зориулалт</td>
                    <td class="value-text"><?= htmlspecialchars($data['purpose']) ?></td>

                    <td class="label">Үнэлгээний огноо</td>
                    <td class="value-text"><?= htmlspecialchars($data['valuation_date']) ?></td>
                </tr>

                <tr>
                    <td class="label">Талбай</td>
                    <td class="value-text"><?= final_fmt($data['area'], 1) ?> м²</td>

                    <td class="label">Давхар</td>
                    <td class="value-text"><?= final_fmt($data['floor']) ?> / <?= final_fmt($data['total_floors']) ?></td>
                </tr>

                <tr>
                    <td class="label">Ашиглалтад орсон он</td>
                    <td class="value-text"><?= htmlspecialchars($data['year_built']) ?></td>

                    <td class="label">1 м² эцсийн үнэ</td>
                    <td class="value-text"><span id="left_sqm_price_view"><?= final_fmt($pricePerSqm) ?></span> ₮</td>
                </tr>
            </table>
        </div>

        <!-- 2 -->
        <div class="final-section">
            <div class="final-section-title">2. Эцсийн үнэлгээний нэгтгэл</div>

            <div class="result-summary">
                <div class="result-mini-box">
                    <div class="mini-label">Жинлэсэн дундаж үнэ</div>
                    <div class="mini-value" id="weighted_value_view"><?= final_fmt($weightedValue) ?> ₮</div>
                </div>

                <div class="result-mini-box">
                    <div class="mini-label">Эцсийн үнэлгээ</div>
                    <div class="mini-value" id="rounded_value_view"><?= final_fmt($roundedValue) ?> ₮</div>
                </div>

                <div class="result-mini-box">
                    <div class="mini-label">1 м² эцсийн үнэ</div>
                    <div class="mini-value"><span id="sqm_price_view"><?= final_fmt($pricePerSqm) ?></span> ₮</div>
                </div>
            </div>

            <div class="muted-note">
                Аргуудын үр дүнгийн хамгийн их зөрүү: <strong><?= final_fmt($variancePercent, 1) ?>%</strong>
            </div>
        </div>

        <!-- 3 -->
        <div class="final-section">
            <div class="final-section-title">3. Арга тус бүрийн жин ба үр дүн</div>

            <div class="preset-row">
                <button type="button" class="preset-btn" onclick="setFinalWeights(0,0,100)">0 / 0 / 100</button>
                <button type="button" class="preset-btn" onclick="setFinalWeights(33,33,34)">33 / 33 / 34</button>
                <button type="button" class="preset-btn" onclick="setFinalWeights(40,40,20)">40 / 40 / 20</button>
                <button type="button" class="preset-btn" onclick="setFinalWeights(15,15,70)">15 / 15 / 70</button>
            </div>

            <table class="final-table">
                <thead>
                    <tr>
                        <th>Арга</th>
                        <th style="width:180px;">Үр дүн</th>
                        <th style="width:140px;">Жин (%)</th>
                        <th style="width:180px;">Жинлэсэн дүн</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Өртгийн хандлага
                            <span class="weight-bar"><span class="weight-bar-fill" id="bar_cost"></span></span>
                        </td>
                        <td class="text-right"><?= final_fmt($costValue) ?> ₮</td>
                        <td class="text-right">
                            <div class="weight-input-wrap">
                                <input type="number" name="weight_cost" id="weight_cost" class="weight-input" min="0" max="100" step="1" value="<?= htmlspecialchars($wCost) ?>">
                                <span>%</span>
                            </div>
                        </td>
                        <td class="text-right" id="weighted_cost_view"><?= final_fmt(($costValue * $wCost) / 100) ?> ₮</td>
                    </tr>

                    <tr>
                        <td>
                            Орлогын хандлага
                            <span class="weight-bar"><span class="weight-bar-fill" id="bar_income"></span></span>
                        </td>
                        <td class="text-right"><?= final_fmt($incomeValue) ?> ₮</td>
                        <td class="text-right">
                            <div class="weight-input-wrap">
                                <input type="number" name="weight_income" id="weight_income" class="weight-input" min="0" max="100" step="1" value="<?= htmlspecialchars($wIncome) ?>">
                                <span>%</span>
                            </div>
                        </td>
                        <td class="text-right" id="weighted_income_view"><?= final_fmt(($incomeValue * $wIncome) / 100) ?> ₮</td>
                    </tr>

                    <tr>
                        <td>
                            Зах зээлийн хандлага
                            <span class="weight-bar"><span class="weight-bar-fill" id="bar_market"></span></span>
                        </td>
                        <td class="text-right"><?= final_fmt($marketValue) ?> ₮</td>
                        <td class="text-right">
                            <div class="weight-input-wrap">
                                <input type="number" name="weight_market" id="weight_market" class="weight-input" min="0" max="100" step="1" value="<?= htmlspecialchars($wMarket) ?>">
                                <span>%</span>
                            </div>
                        </td>
                        <td class="text-right" id="weighted_market_view"><?= final_fmt(($marketValue * $wMarket) / 100) ?> ₮</td>
                    </tr>

                    <tr>
                        <td><strong>Нийт</strong></td>
                        <td class="text-right">—</td>
                        <td class="text-right" id="total_weight_view"><strong><?= final_fmt($totalWeight) ?>%</strong></td>
                        <td class="text-right" id="weighted_total_view"><strong><?= final_fmt((($costValue * $wCost)+($incomeValue * $wIncome)+($marketValue * $wMarket))/100) ?> ₮</strong></td>
                    </tr>
                </tbody>
            </table>

            <div class="status-line <?= $ready ? 'status-ok' : 'status-error' ?>" id="weight_status_box">
                <?= $ready ? 'Жингийн нийлбэр 100% байна.' : 'Жингийн нийлбэр 100% байх ёстой.' ?>
            </div>
        </div>

        <!-- 4 -->
        <div class="final-section">
            <div class="final-section-title">4. Дүгнэлт ба тэмдэглэл</div>

            <table class="final-table">
                <tr>
                    <td class="label">Үнэлгээчний дүгнэлт</td>
                    <td class="value">
                        <textarea class="final-textarea" name="final_comment" id="final_comment"><?= htmlspecialchars($data['comment']) ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="label">Онцгой нөхцөл / Тэмдэглэл</td>
                    <td class="value">
                        <textarea class="final-textarea" name="special_condition" id="special_condition"><?= htmlspecialchars($data['special_condition']) ?></textarea>
                    </td>
                </tr>
            </table>
        </div>

        <div class="final-actions">
            <div class="final-actions-left">
                <button type="submit" formaction="step4.php" class="fbtn fbtn-back">← Back</button>
                <button type="submit" name="save_draft" class="fbtn fbtn-save">Save Draft</button>
            </div>

            <div class="final-actions-right">
                <button type="button" onclick="window.print()" class="fbtn fbtn-back">Print</button>
                <button type="submit" name="preview_final" class="fbtn fbtn-preview">Preview</button>
                <button type="submit" name="finish_final" class="fbtn fbtn-finish" <?= $ready ? '' : 'disabled' ?>>Finish</button>
            </div>
        </div>

        <input type="hidden" name="final_weighted_value" id="final_weighted_value" value="<?= htmlspecialchars($weightedValue) ?>">
        <input type="hidden" name="final_rounded_value" id="final_rounded_value" value="<?= htmlspecialchars($roundedValue) ?>">
        <input type="hidden" name="final_price_per_sqm" id="final_price_per_sqm" value="<?= htmlspecialchars($pricePerSqm) ?>">

        <input type="hidden" name="property_type" value="<?= htmlspecialchars($data['property_type']) ?>">
        <input type="hidden" name="property_name" value="<?= htmlspecialchars($data['property_name']) ?>">
        <input type="hidden" name="address" value="<?= htmlspecialchars($data['address']) ?>">
        <input type="hidden" name="purpose" value="<?= htmlspecialchars($data['purpose']) ?>">
        <input type="hidden" name="valuation_date" value="<?= htmlspecialchars($data['valuation_date']) ?>">
        <input type="hidden" name="area" value="<?= htmlspecialchars($data['area']) ?>">
        <input type="hidden" name="floor" value="<?= htmlspecialchars($data['floor']) ?>">
        <input type="hidden" name="total_floors" value="<?= htmlspecialchars($data['total_floors']) ?>">
        <input type="hidden" name="year_built" value="<?= htmlspecialchars($data['year_built']) ?>">
        <input type="hidden" name="cost_value" value="<?= htmlspecialchars($costValue) ?>">
        <input type="hidden" name="income_value" value="<?= htmlspecialchars($incomeValue) ?>">
        <input type="hidden" name="market_value" value="<?= htmlspecialchars($marketValue) ?>">

    </div>
</div>

<script>
(function(){
    function finalStepNum(v){
        v = String(v || '').replace(/,/g, '').trim();
        let n = parseFloat(v);
        return isNaN(n) ? 0 : n;
    }

    function finalStepFmt(n){
        return Number(n || 0).toLocaleString('en-US');
    }

    function recalcFinalWeights(){
        const costEl = document.getElementById('weight_cost');
        const incomeEl = document.getElementById('weight_income');
        const marketEl = document.getElementById('weight_market');

        if (!costEl || !incomeEl || !marketEl) return;

        const costValue   = <?= json_encode($costValue) ?>;
        const incomeValue = <?= json_encode($incomeValue) ?>;
        const marketValue = <?= json_encode($marketValue) ?>;
        const area        = <?= json_encode($area) ?>;

        let wCost   = finalStepNum(costEl.value);
        let wIncome = finalStepNum(incomeEl.value);
        let wMarket = finalStepNum(marketEl.value);

        const totalWeight = wCost + wIncome + wMarket;

        const weightedCost   = (costValue * wCost) / 100;
        const weightedIncome = (incomeValue * wIncome) / 100;
        const weightedMarket = (marketValue * wMarket) / 100;
        const weightedTotal  = weightedCost + weightedIncome + weightedMarket;

        let weightedValue = 0;
        if(totalWeight > 0){
            weightedValue = (
                (costValue * wCost) +
                (incomeValue * wIncome) +
                (marketValue * wMarket)
            ) / totalWeight;
        }

        const roundedValue = Math.round(weightedValue / 10000) * 10000;
        const sqmPrice = area > 0 ? roundedValue / area : 0;

        const weightedCostView = document.getElementById('weighted_cost_view');
        const weightedIncomeView = document.getElementById('weighted_income_view');
        const weightedMarketView = document.getElementById('weighted_market_view');
        const weightedTotalView = document.getElementById('weighted_total_view');
        const totalWeightView = document.getElementById('total_weight_view');
        const weightedValueView = document.getElementById('weighted_value_view');
        const roundedValueView = document.getElementById('rounded_value_view');
        const sqmPriceView = document.getElementById('sqm_price_view');
        const leftSqmPriceView = document.getElementById('left_sqm_price_view');
        const finalWeightedInput = document.getElementById('final_weighted_value');
        const finalRoundedInput = document.getElementById('final_rounded_value');
        const finalSqmInput = document.getElementById('final_price_per_sqm');
        const barCost = document.getElementById('bar_cost');
        const barIncome = document.getElementById('bar_income');
        const barMarket = document.getElementById('bar_market');
        const finishBtn = document.querySelector('button[name="finish_final"]');
        const statusBox = document.getElementById('weight_status_box');

        if (weightedCostView) weightedCostView.innerText = finalStepFmt(weightedCost) + ' ₮';
        if (weightedIncomeView) weightedIncomeView.innerText = finalStepFmt(weightedIncome) + ' ₮';
        if (weightedMarketView) weightedMarketView.innerText = finalStepFmt(weightedMarket) + ' ₮';
        if (weightedTotalView) weightedTotalView.innerText = finalStepFmt(weightedTotal) + ' ₮';
        if (totalWeightView) totalWeightView.innerHTML = '<strong>' + finalStepFmt(totalWeight) + '%</strong>';
        if (weightedValueView) weightedValueView.innerText = finalStepFmt(weightedValue) + ' ₮';
        if (roundedValueView) roundedValueView.innerText = finalStepFmt(roundedValue) + ' ₮';
        if (sqmPriceView) sqmPriceView.innerText = finalStepFmt(sqmPrice);
        if (leftSqmPriceView) leftSqmPriceView.innerText = finalStepFmt(sqmPrice);

        if (finalWeightedInput) finalWeightedInput.value = weightedValue;
        if (finalRoundedInput) finalRoundedInput.value = roundedValue;
        if (finalSqmInput) finalSqmInput.value = sqmPrice;

        if (barCost) barCost.style.width = Math.max(0, Math.min(100, wCost)) + '%';
        if (barIncome) barIncome.style.width = Math.max(0, Math.min(100, wIncome)) + '%';
        if (barMarket) barMarket.style.width = Math.max(0, Math.min(100, wMarket)) + '%';

        if (finishBtn && statusBox) {
            if(totalWeight === 100 && roundedValue > 0){
                finishBtn.disabled = false;
                statusBox.className = 'status-line status-ok';
                statusBox.innerHTML = 'Жингийн нийлбэр 100% байна.';
            }else{
                finishBtn.disabled = true;
                statusBox.className = 'status-line status-error';
                statusBox.innerHTML = 'Жингийн нийлбэр <b>' + finalStepFmt(totalWeight) + '%</b> байна. 100% болгоно уу.';
            }
        }
    }

    window.setFinalWeights = function(a,b,c){
        const costEl = document.getElementById('weight_cost');
        const incomeEl = document.getElementById('weight_income');
        const marketEl = document.getElementById('weight_market');

        if (costEl) costEl.value = a;
        if (incomeEl) incomeEl.value = b;
        if (marketEl) marketEl.value = c;

        recalcFinalWeights();
    };

    document.addEventListener('DOMContentLoaded', function(){
        ['weight_cost','weight_income','weight_market'].forEach(function(id){
            const el = document.getElementById(id);
            if(el){
                el.addEventListener('input', recalcFinalWeights);
            }
        });

        recalcFinalWeights();
    });
})();
</script>