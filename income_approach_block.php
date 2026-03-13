<?php
// income_approach_block.php
// Энэ файл зөвхөн 'Орлогын хандлага' хүснэгтийг гаргана.
?>
<style id="incomeTable_clean_strong">
/* ===== SAME CLEAN LOOK AS valuation_table_block.php ===== */
#incomeTable{ width:100% !important; border-collapse:collapse !important; font-size:13px !important; }
#incomeTable th, #incomeTable td{
  border:1px solid #333 !important;
  padding:6px 8px !important;
  vertical-align:middle !important;
}
#incomeTable th{
  background:#f3f3f3 !important;
  font-weight:800 !important;
  text-align:center !important;
}
#incomeTable td:nth-child(1){ width:45px !important; text-align:center !important; }
#incomeTable td:nth-child(2){ text-align:left !important; }
#incomeTable td:nth-child(3){ width:200px !important; text-align:center !important; }
#incomeTable td:nth-child(4){ width:220px !important; text-align:right !important; }

/* Inputs inside table */
#incomeTable input, #incomeTable select, #incomeTable textarea{
  width:100% !important;
  height:32px !important;
  padding:4px 8px !important;
  font-size:13px !important;
  border-radius:6px !important;
  box-sizing:border-box !important;
}

/* calculated spans */
#incomeTable span{
  display:block !important;
  padding:4px 8px !important;
  font-weight:800 !important;
}

.income-bold{ font-weight:800 !important; }
.income-muted{ color:#666 !important; }

/* Mobile: keep table, just allow horizontal scroll */
.income-table-wrap{ overflow-x:auto !important; -webkit-overflow-scrolling:touch !important; }
@media (max-width: 768px){
  .income-table-wrap{ border-radius:10px !important; }
  #incomeTable{ min-width: 900px !important; }
  #incomeTable th, #incomeTable td{ white-space:nowrap !important; }
}
</style>

<div class="income-table-wrap">
<table id="incomeTable">
  <thead>
    <tr>
      <th>№</th>
      <th>Үзүүлэлт</th>
      <th>Тооцоолол</th>
      <th>Үнэлэх буй объект</th>
    </tr>
  </thead>

  <tbody>
    <tr>
      <td data-label="№">1</td>
      <td data-label="Үзүүлэлт">Түрээслэх боломжит талбай м.кв</td>
      <td data-label="Тооцоолол">A</td>
      <td data-label="Үнэлэх буй объект"><input class="income-inp only-float" id="inc_A" readonly inputmode="decimal"></td>
    </tr>

    <tr>
      <td data-label="№">2</td>
      <td data-label="Үзүүлэлт">Сарын түрээсийн орлого</td>
      <td data-label="Тооцоолол">Б</td>
      <td data-label="Үнэлэх буй объект"><input class="income-inp only-float" id="inc_B" readonly inputmode="decimal"></td>
    </tr>

    <tr>
      <td data-label="№">3</td>
      <td data-label="Үзүүлэлт">Боломжит нийт орлого жилээр</td>
      <td data-label="Тооцоолол">В = Б * 12</td>
      <td data-label="Үнэлэх буй объект"><span id="inc_V" class="income-bold"></span></td>
    </tr>

    <tr>
      <td data-label="№">4</td>
      <td data-label="Үзүүлэлт">Хүчин чадал дутуу ашиглалт</td>
      <td data-label="Тооцоолол">Г</td>
      <td data-label="Үнэлэх буй объект"><input class="income-inp only-float" id="inc_G" value="0" inputmode="decimal"></td>
    </tr>

    <tr>
      <td data-label="№">5</td>
      <td data-label="Үзүүлэлт">Орлого цуглуулалтын алдагдал</td>
      <td data-label="Тооцоолол">Д</td>
      <td data-label="Үнэлэх буй объект"><input class="income-inp only-float" id="inc_D" value="0" inputmode="decimal"></td>
    </tr>

    <tr>
      <td data-label="№">6</td>
      <td data-label="Үзүүлэлт">Ашиглалтын бусад орлого</td>
      <td data-label="Тооцоолол">Е</td>
      <td data-label="Үнэлэх буй объект"><input class="income-inp only-float" id="inc_E" value="0" inputmode="decimal"></td>
    </tr>

    <tr>
      <td data-label="№">7</td>
      <td data-label="Үзүүлэлт">Бодит нийт орлого</td>
      <td data-label="Тооцоолол">БНО = В - Г - Д + Е</td>
      <td data-label="Үнэлэх буй объект"><span id="inc_BNO" class="income-bold"></span></td>
    </tr>

    <tr>
      <td data-label="№">8</td>
      <td data-label="Үзүүлэлт">Газрын төлбөр</td>
      <td data-label="Тооцоолол">З1</td>
      <td data-label="Үнэлэх буй объект"><input class="income-inp only-float" id="inc_Z1" value="0" inputmode="decimal"></td>
    </tr>

    <tr>
      <td data-label="№">9</td>
      <td data-label="Үзүүлэлт">Үл хөдлөх хөрөнгийн татвар</td>
      <td data-label="Тооцоолол">З2</td>
      <td data-label="Үнэлэх буй объект"><input class="income-inp only-float" id="inc_Z2" value="0" inputmode="decimal"></td>
    </tr>

    <tr>
      <td data-label="№">10</td>
      <td data-label="Үзүүлэлт">Дулаан, цахилгаан, ус</td>
      <td data-label="Тооцоолол">З3</td>
      <td data-label="Үнэлэх буй объект"><input class="income-inp only-float" id="inc_Z3" value="0" inputmode="decimal"></td>
    </tr>

    <tr>
      <td data-label="№">11</td>
      <td data-label="Үзүүлэлт">Харуул хамгаалалт</td>
      <td data-label="Тооцоолол">З4</td>
      <td data-label="Үнэлэх буй объект"><input class="income-inp only-float" id="inc_Z4" value="0" inputmode="decimal"></td>
    </tr>

    <tr>
      <td data-label="№">12</td>
      <td data-label="Үзүүлэлт">Элэгдэл</td>
      <td data-label="Тооцоолол">З5</td>
      <td data-label="Үнэлэх буй объект"><input class="income-inp only-float" id="inc_Z5" readonly inputmode="decimal"></td>
    </tr>

    <tr>
      <td data-label="№">13</td>
      <td data-label="Үзүүлэлт">Урсгал засвар, бусад</td>
      <td data-label="Тооцоолол">З6</td>
      <td data-label="Үнэлэх буй объект"><input class="income-inp only-float" id="inc_Z6" value="0" inputmode="decimal"></td>
    </tr>

    <tr>
      <td data-label="№">14</td>
      <td data-label="Үзүүлэлт">Нийт ашиглалтын зардал</td>
      <td data-label="Тооцоолол">НЗ = З1+З2+З3+З4+З5+З6</td>
      <td data-label="Үнэлэх буй объект"><span id="inc_NZ" class="income-bold"></span></td>
    </tr>

    <tr>
      <td data-label="№">15</td>
      <td data-label="Үзүүлэлт">Капиталжуулах зардал</td>
      <td data-label="Тооцоолол">КЗ</td>
      <td data-label="Үнэлэх буй объект"><input class="income-inp only-float" id="inc_KZ" value="0" inputmode="decimal"></td>
    </tr>

    <tr>
      <td data-label="№">16</td>
      <td data-label="Үзүүлэлт">Зээл ба хүүгийн тэнцүү төлөлт</td>
      <td data-label="Тооцоолол">ЗЭЭ</td>
      <td data-label="Үнэлэх буй объект"><input class="income-inp only-float" id="inc_ZEE" value="0" inputmode="decimal"></td>
    </tr>

    <tr>
      <td data-label="№">17</td>
      <td data-label="Үзүүлэлт">Татварын өмнөх ашиг</td>
      <td data-label="Тооцоолол">ТӨА = БНО - НЗ - КЗ - ЗЭЭ</td>
      <td data-label="Үнэлэх буй объект"><span id="inc_TOA" class="income-bold"></span></td>
    </tr>

    <tr>
      <td data-label="№">18</td>
      <td data-label="Үзүүлэлт">Орлогын татвар</td>
      <td data-label="Тооцоолол">Т = ТӨА * 10%</td>
      <td data-label="Үнэлэх буй объект"><span id="inc_TAX" class="income-bold"></span></td>
    </tr>

    <tr>
      <td data-label="№">19</td>
      <td data-label="Үзүүлэлт">Татварын дараах ашиг</td>
      <td data-label="Тооцоолол">ТДА = ТӨА - Т</td>
      <td data-label="Үнэлэх буй объект"><span id="inc_TDA" class="income-bold"></span></td>
    </tr>

    <tr>
      <td data-label="№">20</td>
      <td data-label="Үзүүлэлт">Цэвэр мөнгөн урсгал</td>
      <td data-label="Тооцоолол">ЦМҮ = ТДА + З5</td>
      <td data-label="Үнэлэх буй объект"><span id="inc_CMU" class="income-bold"></span></td>
    </tr>

    <tr>
      <td data-label="№">21</td>
      <td data-label="Үзүүлэлт">Капиталжуулах хувь</td>
      <td data-label="Тооцоолол">R</td>
      <td data-label="Үнэлэх буй объект"><input class="income-inp only-float" id="inc_R" readonly inputmode="decimal"></td>
    </tr>

    <tr>
      <td data-label="№">22</td>
      <td data-label="Үзүүлэлт" class="income-bold">Үл хөдлөх эд хөрөнгийн үнэ цэнэ</td>
      <td data-label="Тооцоолол" class="income-bold">P = ЦМҮ / R</td>
      <td data-label="Үнэлэх буй объект"><span id="inc_P" class="income-bold"></span></td>
    </tr>
  </tbody>
</table>
</div>