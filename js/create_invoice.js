(function(){

let current=1;

const panels=document.querySelectorAll(".wiz-step-panel");
const pills=document.querySelectorAll(".wiz-pill");

const nextBtn=document.getElementById("wizNext");
const backBtn=document.getElementById("wizBack");
const saveBtn=document.getElementById("wizSave");

const bar=document.getElementById("wizBar");

const total=panels.length;

function show(step){

current=step;

panels.forEach(p=>{
let s=Number(p.dataset.step);
p.classList.toggle("active",s===step);
});

pills.forEach(p=>{
let s=Number(p.dataset.step);
p.classList.toggle("active",s===step);
});

if(bar){
let percent=((step-1)/(total-1))*100;
bar.style.width=percent+"%";
}

if(backBtn) backBtn.style.display=(step===1)?"none":"";
if(nextBtn) nextBtn.style.display=(step===total)?"none":"";
if(saveBtn) saveBtn.style.display=(step===total)?"":"none";

}

nextBtn?.addEventListener("click",()=>{
if(current<total) show(current+1);
});

backBtn?.addEventListener("click",()=>{
if(current>1) show(current-1);
});

pills.forEach(p=>{
p.addEventListener("click",()=>{
show(Number(p.dataset.step));
});
});

show(1);

})();