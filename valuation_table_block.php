<?php
// valuation_table_block.php
// Энэ файл зөвхөн 'Өртгийн хандлага' хүснэгтийг гаргана.
?>
<style id="valTable_clean_strong">
/* ===== STRONG CLEAN LOOK (overrides all) ===== */
#valTable{ width:100% !important; border-collapse:collapse !important; font-size:13px !important; }
#valTable th, #valTable td{
  border:1px solid #333 !important;
  padding:6px 8px !important;
  vertical-align:middle !important;
}
#valTable th{
  background:#f3f3f3 !important;
  font-weight:800 !important;
  text-align:center !important;
}
#valTable td:nth-child(1){ width:45px !important; text-align:center !important; }
#valTable td:nth-child(2){ text-align:left !important; }
#valTable td:nth-child(3){ width:200px !important; text-align:center !important; }
#valTable td:nth-child(4){ width:220px !important; text-align:right !important; }

/* Inputs inside table */
#valTable input, #valTable select, #valTable textarea{
  width:100% !important;
  height:32px !important;
  padding:4px 8px !important;
  font-size:13px !important;
  border-radius:6px !important;
  box-sizing:border-box !important;
}

/* calculated spans */
#valTable span{
  display:block !important;
  padding:4px 8px !important;
  font-weight:800 !important;
}

/* Mobile: keep table, just allow horizontal scroll */
.val-table-wrap{ overflow-x:auto !important; -webkit-overflow-scrolling:touch !important; }
@media (max-width: 768px){
  .val-table-wrap{ border-radius:10px !important; }
  #valTable{ min-width: 900px !important; }
  #valTable th, #valTable td{ white-space:nowrap !important; }
}
</style>



<div class="val-table-wrap">
<table class="val-table" id="valTable">
  <thead>
    <tr>
      <th>№</th>
      <th>Үзүүлэлт</th>
      <th>Тооцоолол</th>
      <th>Үнэлэх буй объект</th>
    </tr>
  </thead>

  <tbody>
    <tr><td data-label="№">1</td><td data-label="Үзүүлэлт">Ашиглалтад орсон он</td><td data-label="Тооцоолол">A</td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-int" id="A" value="2004" inputmode="numeric" maxlength="4"></td></tr>

    <tr><td data-label="№">2</td><td data-label="Үзүүлэлт">Хэмжих нэгж</td><td data-label="Тооцоолол">Б</td>
      <td data-label="Үнэлэх буй объект" style="text-align:left"><input class="val-inp" id="unit" value="м.кв" style="text-align:left"></td></tr>

    <tr><td data-label="№">3</td><td data-label="Үзүүлэлт">Талбай /УБГ дээрх/</td><td data-label="Тооцоолол">Б1</td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="B1" inputmode="decimal"></td></tr>

    <tr><td data-label="№">4</td><td data-label="Үзүүлэлт">Талбайн итгэлцүүр</td><td data-label="Тооцоолол">Б2</td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="B2" inputmode="decimal"></td></tr>

    <tr><td data-label="№">5</td><td data-label="Үзүүлэлт">Тэнхлэгээрх талбай /м.кв/</td><td data-label="Тооцоолол">Б=Б1 * Б2</td>
      <td data-label="Үнэлэх буй объект"><span id="B" class="val-bold"></span></td></tr>

    <tr><td data-label="№">6</td><td data-label="Үзүүлэлт">Нэгжийн жиших үнэлгээ /БХБС-ын 203 тогтоолыг үндэслэв/</td><td data-label="Тооцоолол">Г</td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="G" value="1120650" inputmode="decimal"></td></tr>

    <tr><td data-label="№">7</td><td data-label="Үзүүлэлт">Тохируулга</td><td data-label="Тооцоолол" class="val-muted">&nbsp;</td>
      <td data-label="Үнэлэх буй объект"><span id="K" class="val-bold"></span></td></tr>

    <tr><td data-label="№">8</td><td data-label="Үзүүлэлт">Үнийн өсөлтийн</td><td data-label="Тооцоолол">И1</td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="I1"></td></tr>

    <tr><td data-label="№">9</td><td data-label="Үзүүлэлт">Шууд зардлын</td><td data-label="Тооцоолол">И2</td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="I2" value="1.00" inputmode="decimal"></td></tr>

    <tr><td data-label="№">10</td><td data-label="Үзүүлэлт">Байгалийн зарим хүчин зүйлийн нөлөөллийн</td><td data-label="Тооцоолол">И3</td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="I3" value="1.00" inputmode="decimal"></td></tr>

    <tr><td data-label="№">11</td><td data-label="Үзүүлэлт">Тээврийн зардлын</td><td data-label="Тооцоолол">И4</td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="I4" value="1.00" inputmode="decimal"></td></tr>

    <tr><td data-label="№">12</td><td data-label="Үзүүлэлт">Төхөөрөмжлөгдсөн байдлын</td><td data-label="Тооцоолол">И5</td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="I5" value="1.00" inputmode="decimal"></td></tr>

    <tr><td data-label="№">13</td><td data-label="Үзүүлэлт">Инженерийн шугам сүлжээнд холбогдсон байдлын</td><td data-label="Тооцоолол">И6</td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="I6" value="1.00" inputmode="decimal"></td></tr>

    <tr><td data-label="№">14</td><td data-label="Үзүүлэлт">Барилгын өндөрийн</td><td data-label="Тооцоолол">И7</td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="I7" value="1.00" inputmode="decimal"></td></tr>

    <tr><td data-label="№">15</td><td data-label="Үзүүлэлт">Барилгын ханын зузааны</td><td data-label="Тооцоолол">И8</td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="I8" value="1.00" inputmode="decimal"></td></tr>

    <tr><td data-label="№">16</td><td data-label="Үзүүлэлт">Барилгын хийцийн</td><td data-label="Тооцоолол">И9</td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="I9" value="1.00" inputmode="decimal"></td></tr>

    <tr><td data-label="№">17</td><td data-label="Үзүүлэлт">Бусад хүчин зүйлийн</td><td data-label="Тооцоолол">И10</td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="I10" value="1.00" inputmode="decimal"></td></tr>

    <tr><td data-label="№">18</td><td data-label="Үзүүлэлт">Тохируулагдсан ортуулалтын нэгж өртөг</td>
      <td data-label="Тооцоолол">Нэгж. Өртөг=Б*∏<sub>i=1</sub><sup>10</sup> И<sub>i</sub></td>
      <td data-label="Үнэлэх буй объект"><span id="unitCost" class="val-bold"></span></td></tr>

    <tr><td data-label="№">19</td><td data-label="Үзүүлэлт">Бүрэн ортуулалтын өртөг</td>
      <td data-label="Тооцоолол">БОӨ=Б*Нэгж. Өртөг</td>
      <td data-label="Үнэлэх буй объект"><span id="BOO" class="val-bold"></span></td></tr>

    <tr><td data-label="№">20</td><td data-label="Үзүүлэлт">Ашиглалтын хугацаанд элэгдэл хугацаа*, жил</td>
      <td data-label="Тооцоолол">Т<sub>аш</sub></td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="Tash" value="39.0" inputmode="decimal"></td></tr>

    <tr><td data-label="№">21</td><td data-label="Үзүүлэлт">Ашиглалтын норматив хугацаа*, жил</td>
      <td data-label="Тооцоолол">Т<sub>норм</sub></td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="Tnorm"></td></tr>

    <tr><td data-label="№">22</td><td data-label="Үзүүлэлт">Бует элэгдэл</td>
      <td data-label="Тооцоолол">Э<sub>бует</sub>=БОӨ*(Т<sub>аш</sub>/Т<sub>норм</sub>)</td>
      <td data-label="Үнэлэх буй объект"><span id="Ephys" class="val-bold"></span></td></tr>

    <tr><td data-label="№">23</td><td data-label="Үзүүлэлт">Үйл ажиллагааны/игүүргийн хорогдол</td>
      <td data-label="Тооцоолол">Э<sub>ҮА</sub></td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="Eua" value="-" style="text-align:right"></td></tr>

    <tr><td data-label="№">24</td><td data-label="Үзүүлэлт">Эдийн засгийн хорогдол</td>
      <td data-label="Тооцоолол">Э<sub>эдзас</sub></td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="Eeco" value="-" style="text-align:right"></td></tr>

    <tr><td data-label="№">25</td><td data-label="Үзүүлэлт">Нийт элэгдлийн дүн</td>
      <td data-label="Тооцоолол">ХЭЭ=Э<sub>бует</sub>+Э<sub>ҮА</sub>+Э<sub>эдзас</sub></td>
      <td data-label="Үнэлэх буй объект"><span id="HEE" class="val-bold"></span></td></tr>

    <tr><td data-label="№">26</td><td data-label="Үзүүлэлт">Капиталжуулах зардлын өнөөгийн үнэ цэнэ</td>
      <td data-label="Тооцоолол">PV<sub>кз</sub></td>
      <td data-label="Үнэлэх буй объект"><input class="val-inp only-float" id="PVkz" value="-" style="text-align:right"></td></tr>

    <tr><td data-label="№">27</td><td data-label="Үзүүлэлт" class="val-bold">Үнэлгээний дүн</td>
      <td data-label="Тооцоолол" class="val-bold">P=БОӨ-ХЭЭ</td>
      <td data-label="Үнэлэх буй объект"><span id="P" class="val-bold"></span></td></tr>
  </tbody>
</table>
</div>
