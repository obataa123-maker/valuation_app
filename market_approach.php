<?php
if (!defined('ABSPATH')) { /* optional */ }
?>

<link rel="stylesheet" href="./css/calculator.css">
<script src="./js/calculator.js"></script>
<script src="./js/market_approach_calc.js"></script>

<style>
.vertical-10,
.vertical-12{
    padding: 0 !important;
    text-align: center;
    vertical-align: middle !important;
}

.vertical-box{
    display: flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    margin: 0 auto;
    overflow: hidden;
}

.vertical-10 .vertical-box{
    height: 260px;
}

.vertical-12 .vertical-box{
    height: 320px;
}

.vertical-box span{
    display: inline-block;
    transform: rotate(-90deg);
    white-space: nowrap;
    font-weight: normal;
    font-size: 12px;
    line-height: 1;
}

.market-approach-table{
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    font-size: 12px;
}

.market-approach-table td,
.market-approach-table th{
    vertical-align: middle !important;
    word-break: break-word;
    overflow-wrap: anywhere;
}

.market-approach-table input,
.market-approach-table textarea{
    width: 100%;
    box-sizing: border-box;
    border: 0;
    outline: none;
    padding: 4px 6px;
    font-size: 12px;
    font-family: inherit;
    background: transparent;
    vertical-align: middle;
}

.market-approach-table textarea{
    resize: none;
    min-height: 44px;
    line-height: 1.35;
    overflow: hidden;
    white-space: pre-wrap;
    word-break: break-word;
    overflow-wrap: anywhere;
}

.market-approach-table input[type="month"]{
    width:100%;
    border:0;
    background:transparent;
    font-size:12px;
}

.market-approach-wrap{
  width:100%;
  margin:0;
  padding:0;
}

.market-approach-table{
  width:100% !important;
  max-width:1150px;
  margin:0 auto;
  border-collapse:separate;
  border-spacing:0;
  table-layout:fixed;
  font-size:12px;
  color:#111;
  background:#fff;
}

.market-approach-table th,
.market-approach-table td{
  border:1px solid rgba(0,0,0,.12) !important;
  padding:8px 10px;
  vertical-align:middle !important;
  background:#fff;
}

.market-approach-table th{
  background:#f3f4f6 !important;
  font-weight:700;
  text-align:center;
}

.market-approach-table input,
.market-approach-table textarea,
.market-approach-table select{
  width:100%;
  box-sizing:border-box;
  border:0;
  outline:none;
  padding:6px 8px;
  font-size:12px;
  background:transparent;
  color:#111;
}

.market-approach-table textarea{
  resize:none;
  min-height:44px;
  overflow:hidden;
  white-space:pre-wrap;
  word-break:break-word;
}

.market-approach-table tr:hover td{
  background:#fafafa;
}

</style>

<script>
document.addEventListener('input', function(e){
    if(e.target.matches('.market-approach-table textarea')){
        e.target.style.height = 'auto';
        e.target.style.height = e.target.scrollHeight + 'px';
    }
});

document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.market-approach-table textarea').forEach(function(el){
        el.style.height = 'auto';
        el.style.height = el.scrollHeight + 'px';
    });
});
</script>

<div class="market-approach-wrap">
  <table class="market-approach-table" border="1" cellspacing="0" cellpadding="3" style="width:100%; border-collapse:collapse; table-layout:fixed; font-size:12px;">
    <colgroup>
      <col style="width:34px;">
      <col style="width:34px;">
      <col style="width:220px;">
      <col style="width:90px;">
      <col style="width:auto;">
      <col style="width:auto;">
      <col style="width:auto;">
    </colgroup>

    <tr style="text-align:center; background:#efefef;">
      <th rowspan="2">№</th>
      <th colspan="2" rowspan="2">Үзүүлэлтүүд</th>
      <th rowspan="2">Тооцоолол</th>
      <th colspan="3">Харьцуулах хөрөнгө</th>
    </tr>
    <tr style="text-align:center; background:#efefef;">
      <th>Жишиг №1</th>
      <th>Жишиг №2</th>
      <th>Жишиг №3</th>
    </tr>

    <!-- 1 -->
    <tr>
      <td rowspan="10" style="text-align:center; vertical-align:top;">1</td>
      <td colspan="2">Эх сурвалж</td>
      <td style="text-align:center;">M</td>
      <td><textarea id="ma_src_1"></textarea></td>
      <td><textarea id="ma_src_2"></textarea></td>
      <td><textarea id="ma_src_3"></textarea></td>
    </tr>
    <tr>
      <td colspan="2">Борлуулагчийн харилцах утас</td>
      <td></td>
      <td><textarea id="ma_phone_1"></textarea></td>
      <td><textarea id="ma_phone_2"></textarea></td>
      <td><textarea id="ma_phone_3"></textarea></td>
    </tr>
    <tr>
      <td colspan="2">Байршил</td>
      <td></td>
      <td><textarea id="ma_location_1"></textarea></td>
      <td><textarea id="ma_location_2"></textarea></td>
      <td><textarea id="ma_location_3"></textarea></td>
    </tr>
    <tr>
      <td colspan="2">Давхар</td>
      <td></td>
      <td><input type="text" id="ma_floor_1"></td>
      <td><input type="text" id="ma_floor_2"></td>
      <td><input type="text" id="ma_floor_3"></td>
    </tr>
    <tr>
      <td colspan="2">Үл хөдлөх хөрөнгийн талбайн хэмжээ</td>
      <td></td>
      <td><input type="text" id="ma_area_1"></td>
      <td><input type="text" id="ma_area_2"></td>
      <td><input type="text" id="ma_area_3"></td>
    </tr>
    <tr>
      <td colspan="2">Хөрөнгийн хийц</td>
      <td></td>
      <td><input type="text" id="ma_structure_1"></td>
      <td><input type="text" id="ma_structure_2"></td>
      <td><input type="text" id="ma_structure_3"></td>
    </tr>
    <tr>
      <td colspan="2">Тоноглол, төхөөрөмжлөгдсөн байдал</td>
      <td></td>
      <td><textarea id="ma_utility_1"></textarea></td>
      <td><textarea id="ma_utility_2"></textarea></td>
      <td><textarea id="ma_utility_3"></textarea></td>
    </tr>
    <tr>
      <td colspan="2">Эдийн засгийн шинж чанар</td>
      <td></td>
      <td><textarea id="ma_economic_1"></textarea></td>
      <td><textarea id="ma_economic_2"></textarea></td>
      <td><textarea id="ma_economic_3"></textarea></td>
    </tr>
    <tr>
      <td colspan="2">Ашиглалтад орсон огноо</td>
      <td></td>
      <td><input type="number" id="ma_use_date_1" min="1940" max="2100" step="1" placeholder="Он"></td>
      <td><input type="number" id="ma_use_date_2" min="1940" max="2100" step="1" placeholder="Он"></td>
      <td><input type="number" id="ma_use_date_3" min="1940" max="2100" step="1" placeholder="Он"></td>
    </tr>
    <tr>
      <td colspan="2">Худалдсан, санал болгосон он, сар</td>
      <td></td>
      <td><input type="date" id="ma_offer_date_1"></td>
      <td><input type="date" id="ma_offer_date_2"></td>
      <td><input type="date" id="ma_offer_date_3"></td>
    </tr>

    <!-- 2 -->
    <tr>
      <td style="text-align:center;">2</td>
      <td colspan="2">Санал болгосон үнэ</td>
      <td style="text-align:center;">A</td>
      <td><input type="text" id="ma_a_1" class="num-format"></td>
      <td><input type="text" id="ma_a_2" class="num-format"></td>
      <td><input type="text" id="ma_a_3" class="num-format"></td>
    </tr>

    <!-- 3 -->
    <tr>
      <td rowspan="10" class="vertical-10">
        <div class="vertical-box">
          <span>3. Ажил гүйлгээний тохируулга</span>
        </div>
      </td>
      <td style="text-align:center;">1</td>
      <td>Үл хөдлөх хөрөнгийн шилжүүлэх эрхийн тохируулга</td>
      <td style="text-align:center;">TA₁</td>
      <td><input type="text" id="ma_ta1_1" class="calcable"></td>
      <td><input type="text" id="ma_ta1_2" class="calcable"></td>
      <td><input type="text" id="ma_ta1_3" class="calcable"></td>
    </tr>
    <tr>
      <td></td>
      <td>Тохируулга хийгдсэн дүн</td>
      <td style="text-align:center;">B=A±TA₁</td>
      <td><input type="text" id="ma_b_ta1_1" readonly></td>
      <td><input type="text" id="ma_b_ta1_2"></td>
      <td><input type="text" id="ma_b_ta1_3"></td>
    </tr>
    <tr>
      <td style="text-align:center;">2</td>
      <td>Санхүүжилтын нөхцөлийн тохируулга</td>
      <td style="text-align:center;">TA₂</td>
      <td><input type="text" id="ma_ta2_1" class="calcable"></td>
      <td><input type="text" id="ma_ta2_2" class="calcable"></td>
      <td><input type="text" id="ma_ta2_3" class="calcable"></td>
    </tr>
    <tr>
      <td></td>
      <td>Тохируулга хийгдсэн дүн</td>
      <td style="text-align:center;">B=A±TA₂</td>
      <td><input type="text" id="ma_b_ta2_1"></td>
      <td><input type="text" id="ma_b_ta2_2"></td>
      <td><input type="text" id="ma_b_ta2_3"></td>
    </tr>
    <tr>
      <td style="text-align:center;">3</td>
      <td>Борлуулалт хэлцлийн нөхцөлийн тохируулга</td>
      <td style="text-align:center;">TA₃=B</td>
      <td><input type="text" id="ma_ta3_1" class="calcable"></td>
      <td><input type="text" id="ma_ta3_2" class="calcable"></td>
      <td><input type="text" id="ma_ta3_3" class="calcable"></td>
    </tr>
    <tr>
      <td></td>
      <td>Тохируулга хийгдсэн дүн</td>
      <td style="text-align:center;">B=A±TA₃</td>
      <td><input type="text" id="ma_b_ta3_1"></td>
      <td><input type="text" id="ma_b_ta3_2"></td>
      <td><input type="text" id="ma_b_ta3_3"></td>
    </tr>
    <tr>
      <td style="text-align:center;">4</td>
      <td>Худалдан авсны дараа гарах зардлын тохируулга</td>
      <td style="text-align:center;">TA₄</td>
      <td><input type="text" id="ma_ta4_1" class="calcable"></td>
      <td><input type="text" id="ma_ta4_2" class="calcable"></td>
      <td><input type="text" id="ma_ta4_3" class="calcable"></td>
    </tr>
    <tr>
      <td></td>
      <td>Тохируулга хийгдсэн дүн</td>
      <td style="text-align:center;">B=A±TA₄</td>
      <td><input type="text" id="ma_b_ta4_1"></td>
      <td><input type="text" id="ma_b_ta4_2"></td>
      <td><input type="text" id="ma_b_ta4_3"></td>
    </tr>
    <tr>
      <td style="text-align:center;">5</td>
      <td>Зах зээлийн нөхцөл байдлын тохируулга</td>
      <td style="text-align:center;">TA₅</td>
      <td><input type="text" id="ma_ta5_1" class="calcable"></td>
      <td><input type="text" id="ma_ta5_2" class="calcable"></td>
      <td><input type="text" id="ma_ta5_3" class="calcable"></td>
    </tr>
    <tr>
      <td></td>
      <td>Тохируулга хийгдсэн дүн</td>
      <td style="text-align:center;">B=A±TA₅</td>
      <td><input type="text" id="ma_b_ta5_1"></td>
      <td><input type="text" id="ma_b_ta5_2"></td>
      <td><input type="text" id="ma_b_ta5_3"></td>
    </tr>

    <!-- 4 -->
    <tr>
      <td style="text-align:center;">4</td>
      <td colspan="2">Арилжааны тохируулга хийгдсэн жишиг үнэ</td>
      <td style="text-align:center;">B=A±TA₅</td>
      <td><input type="text" id="ma_b_final_1"></td>
      <td><input type="text" id="ma_b_final_2"></td>
      <td><input type="text" id="ma_b_final_3"></td>
    </tr>

    <!-- 5 -->
    <tr>
      <td style="text-align:center;">5</td>
      <td colspan="2">Үнэлгээний гол хэмжигдэхүүн</td>
      <td style="text-align:center;">C</td>
      <td><input type="text" id="ma_c_1" readonly></td>
      <td><input type="text" id="ma_c_2" readonly></td>
      <td><input type="text" id="ma_c_3" readonly></td>
    </tr>

    <!-- 6 -->
    <tr>
      <td style="text-align:center;">6</td>
      <td colspan="2">Нэгжийн жиших үнэ</td>
      <td style="text-align:center;">D=B/C</td>
      <td><input type="text" id="ma_d_1"></td>
      <td><input type="text" id="ma_d_2"></td>
      <td><input type="text" id="ma_d_3"></td>
    </tr>

    <!-- 7 -->
    <tr>
      <td rowspan="12" class="vertical-12">
        <div class="vertical-box">
          <span>7. Хөрөнгийн тохируулга</span>
        </div>
      </td>
      <td style="text-align:center;">1</td>
      <td>Байршил, бүсчлэлийн итгэлцүүр</td>
      <td style="text-align:center;">И₁</td>
      <td><input type="text" id="ma_i1_1" value="1" class="calcable"></td>
      <td><input type="text" id="ma_i1_2" value="1" class="calcable"></td>
      <td><input type="text" id="ma_i1_3" value="1" class="calcable"></td>
    </tr>
    <tr>
      <td></td>
      <td>Тайлбар</td>
      <td></td>
      <td colspan="3"><textarea id="ma_i1_note"></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;">2</td>
      <td>Биет шинж чанарын тохируулга</td>
      <td style="text-align:center;">И₂</td>
      <td><input type="text" id="ma_i2_1" value="1" class="calcable"></td>
      <td><input type="text" id="ma_i2_2" value="1" class="calcable"></td>
      <td><input type="text" id="ma_i2_3" value="1" class="calcable"></td>
    </tr>
    <tr>
      <td></td>
      <td>Тайлбар</td>
      <td></td>
      <td colspan="3"><textarea id="ma_i2_note"></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;">3</td>
      <td>Эдийн засгийн шинж чанарын тохируулга</td>
      <td style="text-align:center;">И₄</td>
      <td><input type="text" id="ma_i4_1" value="1" class="calcable"></td>
      <td><input type="text" id="ma_i4_2" value="1" class="calcable"></td>
      <td><input type="text" id="ma_i4_3" value="1" class="calcable"></td>
    </tr>
    <tr>
      <td></td>
      <td>Тайлбар</td>
      <td></td>
      <td colspan="3"><textarea id="ma_i4_note"></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;">4</td>
      <td>Эрх зүйн шинж чанарын тохируулга</td>
      <td style="text-align:center;">И₅</td>
      <td><input type="text" id="ma_i5_1" value="1" class="calcable"></td>
      <td><input type="text" id="ma_i5_2" value="1" class="calcable"></td>
      <td><input type="text" id="ma_i5_3" value="1" class="calcable"></td>
    </tr>
    <tr>
      <td></td>
      <td>Тайлбар</td>
      <td></td>
      <td colspan="3"><textarea id="ma_i5_note"></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;">5</td>
      <td>Хийцийн тохируулга</td>
      <td style="text-align:center;">И₆</td>
      <td><input type="text" id="ma_i6_1" value="1" class="calcable"></td>
      <td><input type="text" id="ma_i6_2" value="1" class="calcable"></td>
      <td><input type="text" id="ma_i6_3" value="1" class="calcable"></td>
    </tr>
    <tr>
      <td></td>
      <td>Тайлбар</td>
      <td></td>
      <td colspan="3"><textarea id="ma_i6_note"></textarea></td>
    </tr>
    <tr>
      <td style="text-align:center;">6</td>
      <td>Төхөөрөмжлөгдсөн байдлын тохируулга</td>
      <td style="text-align:center;">И₇</td>
      <td><input type="text" id="ma_i7_1" value="1" class="calcable"></td>
      <td><input type="text" id="ma_i7_2" value="1" class="calcable"></td>
      <td><input type="text" id="ma_i7_3" value="1" class="calcable"></td>
    </tr>
    <tr>
      <td></td>
      <td>Тайлбар</td>
      <td></td>
      <td colspan="3"><textarea id="ma_i7_note"></textarea></td>
    </tr>

    <!-- 8 -->
    <tr>
      <td style="text-align:center;">8</td>
      <td colspan="2">Хөрөнгийн тохируулгын хэмжээ</td>
      <td style="text-align:center;">Иⱼ = ∏ Иᵢ</td>
      <td><input type="text" id="ma_ij_1"></td>
      <td><input type="text" id="ma_ij_2"></td>
      <td><input type="text" id="ma_ij_3"></td>
    </tr>

    <!-- 9 -->
    <tr>
      <td style="text-align:center;">9</td>
      <td colspan="2">Тохируулга хийгдсэн нэгжийн үнэ</td>
      <td style="text-align:center;">Eⱼ=Dⱼ*Иⱼ</td>
      <td><input type="text" id="ma_ej_1"></td>
      <td><input type="text" id="ma_ej_2"></td>
      <td><input type="text" id="ma_ej_3"></td>
    </tr>

    <!-- 10 -->
    <tr>
      <td rowspan="2" style="text-align:center;">10</td>
      <td style="text-align:center;">1</td>
      <td>Ач холбогдлын коэффициент</td>
      <td style="text-align:center;">∑Wⱼ = 1</td>
      <td><input type="text" id="ma_w_1"></td>
      <td><input type="text" id="ma_w_2"></td>
      <td><input type="text" id="ma_w_3"></td>
    </tr>
    <tr>
      <td style="text-align:center;">2</td>
      <td>Жинлэсэн дүн</td>
      <td style="text-align:center;">Fⱼ=Eⱼ*Tⱼ</td>
      <td><input type="text" id="ma_fj_1"></td>
      <td><input type="text" id="ma_fj_2"></td>
      <td><input type="text" id="ma_fj_3"></td>
    </tr>

    <!-- 11 -->
    <tr>
      <td style="text-align:center;">11</td>
      <td colspan="2">Зах зээлийн дундаж нэгж үнэ</td>
      <td style="text-align:center;">P = ∑Fⱼ</td>
      <td colspan="3"><input type="text" id="ma_p"></td>
    </tr>

    <!-- 12 -->
    <tr>
      <td style="text-align:center;">12</td>
      <td colspan="2">Үнэлж байгаа хөрөнгийн үнэлгээний хэмжигдэхүүн</td>
      <td style="text-align:center;">G</td>
      <td colspan="3"><input type="text" id="ma_g" readonly></td>
    </tr>

    <!-- 13 -->
    <tr>
      <td style="text-align:center;">13</td>
      <td colspan="2">Үл хөдлөх хөрөнгийн үнэ цэнэ</td>
      <td style="text-align:center;">V=G*P</td>
      <td colspan="3"><input type="text" id="ma_v" readonly></td>
    </tr>
  </table>
</div>

<script>

function formatNumber(x){
    x = x.replace(/,/g,'');
    if(x === '') return '';
    return Number(x).toLocaleString('en-US');
}

document.addEventListener('input',function(e){

    if(e.target.classList.contains('num-format')){

        let val = e.target.value.replace(/[^0-9]/g,'');

        if(val === ''){
            e.target.value = '';
            return;
        }

        e.target.value = formatNumber(val);
    }

});

</script>

<script>

document.getElementById('ma_area_1').addEventListener('input', function(){
    document.getElementById('ma_c_1').value = this.value;
});

document.getElementById('ma_area_2').addEventListener('input', function(){
    document.getElementById('ma_c_2').value = this.value;
});

document.getElementById('ma_area_3').addEventListener('input', function(){
    document.getElementById('ma_c_3').value = this.value;
});

</script>

<script>
function cleanWeightInput(v) {
    v = String(v || '').replace(/,/g, '').replace(/[^0-9.]/g, '');

    // нэг л цэгтэй байлгах
    const firstDot = v.indexOf('.');
    if (firstDot !== -1) {
        v = v.slice(0, firstDot + 1) + v.slice(firstDot + 1).replace(/\./g, '');
    }

    // хоосон, эсвэл бичиж дуусаагүй төлөв
    if (v === '' || v === '.') return v;

    let n = parseFloat(v);
    if (isNaN(n)) return '';

    // 1-ээс их бол 1 болгоно
    if (n > 1) n = 1;

    // 0-оос бага бол 0 болгоно
    if (n < 0) n = 0;

    return String(v.endsWith('.') ? n.toString() + '.' : n);
}

function parseWeight(v) {
    v = String(v || '').trim();
    if (v === '' || v === '.') return null;
    const n = parseFloat(v);
    return isNaN(n) ? null : n;
}

function formatWeight(n) {
    if (n === null || n === undefined || isNaN(n)) return '';
    return Number(n).toFixed(2);
}

function updateWeights(changedId) {
    const w1El = document.getElementById('ma_w_1');
    const w2El = document.getElementById('ma_w_2');
    const w3El = document.getElementById('ma_w_3');
    const msgEl = document.getElementById('weight_msg');

    // оруулж буй утгыг шууд цэвэрлэнэ
    [w1El, w2El, w3El].forEach(el => {
        if (document.activeElement === el) {
            el.value = cleanWeightInput(el.value);
        }
    });

    let w1 = parseWeight(w1El.value);
    let w2 = parseWeight(w2El.value);
    let w3 = parseWeight(w3El.value);

    const filledCount = [w1, w2, w3].filter(v => v !== null).length;

    // 2 нь бөглөгдсөн бол 3 дахьг бодно
    if (filledCount >= 2) {
        if (changedId !== 'ma_w_1' && w1 !== null && w2 !== null) {
            w3 = +(1 - w1 - w2).toFixed(2);
            if (w3 < 0) w3 = 0;
            w3El.value = formatWeight(w3);
        } else if (changedId !== 'ma_w_2' && w1 !== null && w3 !== null) {
            w2 = +(1 - w1 - w3).toFixed(2);
            if (w2 < 0) w2 = 0;
            w2El.value = formatWeight(w2);
        } else if (changedId !== 'ma_w_3' && w2 !== null && w3 !== null) {
            w1 = +(1 - w2 - w3).toFixed(2);
            if (w1 < 0) w1 = 0;
            w1El.value = formatWeight(w1);
        }
    }

    // нийлбэр шалгах
    const nw1 = parseWeight(w1El.value) || 0;
    const nw2 = parseWeight(w2El.value) || 0;
    const nw3 = parseWeight(w3El.value) || 0;
    const sum = +(nw1 + nw2 + nw3).toFixed(2);

    if (msgEl) {
        if (sum === 1) {
            msgEl.textContent = 'Нийлбэр = 1.00';
            msgEl.style.color = 'green';
        } else {
            msgEl.textContent = 'Нийлбэр = ' + sum.toFixed(2);
            msgEl.style.color = 'red';
        }
    }
}

['ma_w_1', 'ma_w_2', 'ma_w_3'].forEach(function(id) {
    const el = document.getElementById(id);
    if (!el) return;

    el.addEventListener('input', function() {
        updateWeights(id);
    });

    el.addEventListener('blur', function() {
        const n = parseWeight(el.value);
        if (n !== null) el.value = formatWeight(n);
        updateWeights(id);
    });
});
</script>