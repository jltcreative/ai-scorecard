<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AEO Readiness Scorecard | LA & CO Content Agency</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'DM Sans', sans-serif; background: #F8F4ED; color: #1B1815; -webkit-font-smoothing: antialiased; }
  .sc-header { background: #1B1815; padding: 40px 32px 36px; text-align: center; }
  .sc-header h1 { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 400; color: #F8F4ED; margin-bottom: 8px; line-height: 1.2; }
  .sc-header p { font-size: 14px; color: #8A7F75; max-width: 480px; margin: 0 auto; line-height: 1.5; }
  .sc-progress { background: #EDE8E0; height: 3px; }
  .sc-progress-bar { height: 100%; width: 0%; background: #B8145A; transition: width 0.4s ease; }
  .sc-wrap { max-width: 640px; margin: 0 auto; padding: 32px 24px 48px; }
  .sc-cat-label { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.12em; color: #B8145A; margin-bottom: 8px; }
  .sc-cat-title { font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 400; color: #1B1815; margin-bottom: 6px; line-height: 1.25; }
  .sc-cat-ref { font-size: 13px; color: #8A7F75; line-height: 1.5; margin-bottom: 28px; }
  .sc-cat-ref em { font-style: italic; }
  .sc-question { background: #fff; border: 0.5px solid #D4CCBF; padding: 20px 24px; margin-bottom: 16px; transition: border-color 0.2s; }
  .sc-question.answered { border-color: #B8145A; }
  .sc-question-text { font-size: 15px; color: #1B1815; line-height: 1.55; margin-bottom: 14px; font-weight: 500; }
  .sc-options { display: flex; gap: 10px; }
  .sc-opt { flex: 1; padding: 10px 0; font-size: 13px; font-weight: 600; font-family: 'DM Sans', sans-serif; letter-spacing: 0.02em; border: 1.5px solid #D4CCBF; background: transparent; color: #1B1815; cursor: pointer; transition: all 0.15s ease; }
  .sc-opt:hover { border-color: #8A7F75; }
  .sc-opt.sel-yes { border-color: #2D6A4F; background: #2D6A4F; color: #F8F4ED; }
  .sc-opt.sel-partial { border-color: #B8860B; background: #B8860B; color: #F8F4ED; }
  .sc-opt.sel-no { border-color: #B8145A; background: #B8145A; color: #F8F4ED; }
  .sc-nav { display: flex; justify-content: space-between; margin-top: 32px; gap: 12px; }
  .sc-btn-back { padding: 12px 24px; font-size: 13px; font-weight: 600; font-family: 'DM Sans', sans-serif; border: 1.5px solid #D4CCBF; background: transparent; color: #1B1815; cursor: pointer; transition: all 0.2s; }
  .sc-btn-back:disabled { color: #D4CCBF; cursor: default; }
  .sc-btn-next { padding: 12px 32px; font-size: 13px; font-weight: 600; font-family: 'DM Sans', sans-serif; letter-spacing: 0.03em; border: none; background: #D4CCBF; color: #F8F4ED; cursor: default; transition: all 0.2s; }
  .sc-btn-next.active { background: #B8145A; cursor: pointer; }
  .sc-steps { display: flex; justify-content: center; gap: 8px; margin-top: 24px; }
  .sc-step { width: 28px; height: 4px; border-radius: 2px; background: #D4CCBF; transition: background 0.3s; cursor: default; }
  .sc-step.current { background: #B8145A; }
  .sc-step.done { background: #1B1815; cursor: pointer; }

  /* Results */
  .sc-results { display: none; }
  .sc-results.visible { display: block; }
  .sc-score-circle { text-align: center; margin-bottom: 36px; }
  .sc-ring-wrap { position: relative; display: inline-block; }
  .sc-ring-text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; }
  .sc-ring-letter { font-family: 'Playfair Display', serif; font-size: 52px; font-weight: 400; line-height: 1; }
  .sc-ring-pct { font-size: 11px; font-weight: 600; color: #8A7F75; text-transform: uppercase; letter-spacing: 0.1em; margin-top: 2px; }
  .sc-grade-label { font-family: 'Playfair Display', serif; font-size: 22px; color: #1B1815; margin-top: 16px; font-weight: 400; }
  .sc-grade-desc { font-size: 14px; color: #8A7F75; max-width: 440px; margin: 8px auto 0; line-height: 1.55; }

  .sc-breakdown { background: #fff; border: 0.5px solid #D4CCBF; padding: 24px 28px; margin-bottom: 28px; }
  .sc-breakdown-label { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.12em; color: #8A7F75; margin-bottom: 18px; }
  .sc-bar-row { margin-bottom: 14px; }
  .sc-bar-header { display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 13px; }
  .sc-bar-name { font-weight: 600; color: #1B1815; }
  .sc-bar-pct { font-weight: 600; }
  .sc-bar-track { height: 6px; background: #EDE8E0; border-radius: 3px; overflow: hidden; }
  .sc-bar-fill { height: 100%; border-radius: 3px; width: 0%; transition: width 0.8s cubic-bezier(0.4,0,0.2,1); }

  .sc-recs-label { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.12em; color: #8A7F75; margin-bottom: 16px; }
  .sc-rec { padding: 20px 24px; margin-bottom: 12px; border: 0.5px solid #D4CCBF; background: #fff; }
  .sc-rec.primary { background: #1B1815; border: none; }
  .sc-rec-header { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
  .sc-rec-num { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 400; color: #B8145A; line-height: 1; }
  .sc-rec-title { font-size: 14px; font-weight: 600; color: #1B1815; }
  .sc-rec.primary .sc-rec-title { color: #F8F4ED; }
  .sc-rec-score { font-weight: 400; color: #8A7F75; margin-left: 8px; font-size: 12px; }
  .sc-rec-text { font-size: 13px; line-height: 1.6; color: #8A7F75; }
  .sc-rec.primary .sc-rec-text { color: #D4CCBF; }

  .sc-cta { background: #1B1815; padding: 36px 28px; text-align: center; margin-top: 4px; }
  .sc-cta h3 { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 400; color: #F8F4ED; margin-bottom: 8px; }
  .sc-cta p { font-size: 13px; color: #8A7F75; line-height: 1.5; max-width: 380px; margin: 0 auto 20px; }
  .sc-cta-btn { display: inline-flex; align-items: center; gap: 8px; font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 600; letter-spacing: 0.04em; color: #1B1815; background: #F8F4ED; border: none; padding: 14px 32px; text-decoration: none; cursor: pointer; transition: background 0.2s, color 0.2s; }
  .sc-cta-btn:hover { background: #B8145A; color: #F8F4ED; }

  .sc-restart { text-align: center; margin-top: 24px; }
  .sc-restart button { font-family: 'DM Sans', sans-serif; font-size: 12px; font-weight: 600; color: #8A7F75; background: transparent; border: none; cursor: pointer; text-decoration: underline; text-underline-offset: 3px; }

  .sc-footer { text-align: center; padding: 16px 24px 24px; font-size: 11px; color: #8A7F75; }
  .sc-footer a { color: #B8145A; text-decoration: none; }

  .sc-quiz { display: block; }
  .sc-quiz.hidden { display: none; }

  @media (max-width: 600px) {
    .sc-header { padding: 32px 20px 28px; }
    .sc-header h1 { font-size: 24px; }
    .sc-wrap { padding: 24px 16px 40px; }
    .sc-cat-title { font-size: 20px; }
    .sc-question { padding: 16px 18px; }
    .sc-breakdown { padding: 20px 20px; }
    .sc-rec { padding: 16px 18px; }
    .sc-cta { padding: 28px 20px; }
  }
</style>
</head>
<body>

<div class="sc-header">
  <h1>AEO Readiness Scorecard</h1>
  <p>Rate your content strategy across 7 critical AI search dimensions. Get your score and specific recommendations.</p>
</div>

<div class="sc-progress"><div class="sc-progress-bar" id="progressBar"></div></div>

<div class="sc-wrap">
  <div class="sc-quiz" id="quizSection">
    <div id="catLabel" class="sc-cat-label"></div>
    <div id="catTitle" class="sc-cat-title"></div>
    <div id="catRef" class="sc-cat-ref"></div>
    <div id="questionsContainer"></div>
    <div class="sc-nav">
      <button class="sc-btn-back" id="btnBack" onclick="goBack()">&#8592; Back</button>
      <button class="sc-btn-next" id="btnNext" onclick="goNext()">Next Gap &#8594;</button>
    </div>
    <div class="sc-steps" id="stepsContainer"></div>
  </div>

  <div class="sc-results" id="resultsSection">
    <div class="sc-score-circle">
      <div class="sc-ring-wrap">
        <svg width="180" height="180" id="ringSvg" style="transform:rotate(-90deg)">
          <circle cx="90" cy="90" r="80" fill="none" stroke="#D4CCBF" stroke-width="10" opacity="0.4"/>
          <circle cx="90" cy="90" r="80" fill="none" stroke="#B8145A" stroke-width="10" stroke-dasharray="502.65" stroke-dashoffset="502.65" stroke-linecap="round" id="ringCircle" style="transition:stroke-dashoffset 1.2s cubic-bezier(0.4,0,0.2,1)"/>
        </svg>
        <div class="sc-ring-text">
          <div class="sc-ring-letter" id="gradeLetter"></div>
          <div class="sc-ring-pct" id="gradePct"></div>
        </div>
      </div>
      <div class="sc-grade-label" id="gradeLabel"></div>
      <div class="sc-grade-desc" id="gradeDesc"></div>
    </div>
    <div class="sc-breakdown">
      <div class="sc-breakdown-label">Score Breakdown</div>
      <div id="barsContainer"></div>
    </div>
    <div>
      <div class="sc-recs-label">Priority Recommendations</div>
      <div id="recsContainer"></div>
    </div>
    <div class="sc-cta">
      <h3>Want to Close These Gaps?</h3>
      <p>Every article we create is AEO-optimized, schema-marked, and tested across 5 AI platforms before delivery.</p>
      <a href="https://www.golacocontent.com/get-a-quote/" target="_blank" rel="noopener noreferrer" class="sc-cta-btn">Get a Free Quote <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>
    <div class="sc-restart"><button onclick="restart()">Retake Assessment</button></div>
  </div>
</div>

<div class="sc-footer">Built by <a href="https://www.golacocontent.com" target="_blank" rel="noopener noreferrer">LA &amp; CO Content Agency</a></div>

<script>
var CATEGORIES = [
  { id:"extraction", title:"Content Extractability", gap:"Writing for Keywords, Not Extraction", questions:[
    {text:"Do your articles lead with a direct answer in the first 40 words of each section?",weight:3},
    {text:"Are your content sections self-contained \u2014 could each stand alone and still make sense?",weight:3},
    {text:"Do you front-load factual claims with specific data before expanding with context?",weight:2}
  ]},
  { id:"entities", title:"Entity Strategy", gap:"Not Thinking About Entities", questions:[
    {text:"Does your content name specific people, companies, products, and frameworks (not just generic terms)?",weight:3},
    {text:"Do you map entity relationships \u2014 connecting products to parent companies, founders, and competitors?",weight:2},
    {text:"Does each article reference 15+ recognized entities relevant to the topic?",weight:2}
  ]},
  { id:"schema", title:"Schema Markup", gap:"Ignoring Schema Markup", questions:[
    {text:"Is Article/BlogPosting schema implemented on every content page?",weight:3},
    {text:"Do you use FAQ, HowTo, or other content-specific schema types where relevant?",weight:2},
    {text:"Is Author schema with credentials and Organization schema in place?",weight:2}
  ]},
  { id:"testing", title:"AI Platform Testing", gap:"Never Testing on AI Platforms", questions:[
    {text:"Do you test content on ChatGPT, Perplexity, and Google AI before or after publishing?",weight:3},
    {text:"Do you run target queries to check if your content appears in AI-generated answers?",weight:3},
    {text:"Do you document which competitors are cited instead of you?",weight:2}
  ]},
  { id:"platforms", title:"Platform Differences", gap:"Not Accounting for Platform Differences", questions:[
    {text:"Do you understand that ChatGPT, Perplexity, and Google AI Overviews have different citation preferences?",weight:2},
    {text:"Do you optimize differently for each major AI platform?",weight:3},
    {text:"Do you track which platforms cite your content vs. competitors?",weight:2}
  ]},
  { id:"freshness", title:"Content Freshness", gap:"Not Building for Freshness", questions:[
    {text:"Do you update published content at least every 90 days?",weight:3},
    {text:"Is there a systematic refresh calendar (not ad-hoc updates)?",weight:2},
    {text:"Do refreshed articles include updated dates, new data points, and current sources?",weight:2}
  ]},
  { id:"metrics", title:"AI Metrics", gap:"Measuring the Wrong Things", questions:[
    {text:"Do you track AI citation frequency across platforms?",weight:3},
    {text:"Do you measure share of voice in AI-generated responses for your key topics?",weight:2},
    {text:"Do you report on AI visibility alongside traditional SEO metrics?",weight:2}
  ]}
];

var RECS = {
  extraction:{
    low:"Restructure every article section to lead with a direct answer in the first 1\u20132 sentences. Each passage should be self-contained and citable without surrounding context.",
    mid:"Your structure is partially there. Audit your top 10 pages and ensure every H2 section opens with an extractable answer block under 40 words.",
    high:"Strong extractability. Keep refining passage isolation and ensure new content follows the same answer-first pattern."
  },
  entities:{
    low:"Start entity mapping before writing. List every specific person, company, product, and concept relevant to each topic. Aim for 15+ named entities per article.",
    mid:"You\u2019re naming some entities but missing relationship mapping. Connect products to parent companies, founders to organizations, and tools to use cases.",
    high:"Solid entity coverage. Consider building an entity database for your key topics to ensure consistency across articles."
  },
  schema:{
    low:"Implement Article/BlogPosting schema immediately on all content pages. Add Author schema with credentials and Organization schema. This is baseline infrastructure, not optional.",
    mid:"You have basic schema in place. Add FAQ schema to Q&A sections and ensure Author schema includes expertise signals and linked profiles.",
    high:"Good schema foundation. Audit for completeness \u2014 ensure dateModified updates with every refresh and all content types use appropriate schema."
  },
  testing:{
    low:"Build a testing protocol: run 5\u201310 target queries on ChatGPT, Perplexity, and Google AI for every published article. Document what gets cited and what doesn\u2019t.",
    mid:"You\u2019re testing but not systematically. Create a standardized testing checklist and track results over time to identify patterns.",
    high:"Strong testing habits. Expand to include pre-publication testing so you can adjust structure before content goes live."
  },
  platforms:{
    low:"Study platform differences. ChatGPT relies on Bing, Perplexity runs its own crawlers, Google uses its own index. Each requires different optimization. Start tracking which platforms cite you.",
    mid:"You understand the differences conceptually. Now build platform-specific checklists and track citation rates per platform to identify where you\u2019re weakest.",
    high:"Advanced platform awareness. Focus on the platforms where your audience is most active and deepen optimization for those specifically."
  },
  freshness:{
    low:"Set up a 90-day refresh calendar for all published content. Update dates, add new data points, and refresh sources. AI platforms deprioritize stale content aggressively.",
    mid:"You refresh some content but not systematically. Prioritize your highest-traffic articles and build freshness into your editorial calendar.",
    high:"Good refresh discipline. Ensure every update includes genuinely new information \u2014 not just cosmetic date changes, which AI platforms can detect."
  },
  metrics:{
    low:"Start tracking AI citations manually: query your key topics on ChatGPT, Perplexity, and Google AI monthly. Note which brands are cited. Tools like Semrush\u2019s AI Visibility and HubSpot\u2019s AI Search Grader can help automate this.",
    mid:"You\u2019re tracking some AI metrics but not reporting on them consistently. Build AI visibility into your regular reporting alongside traditional SEO KPIs.",
    high:"Comprehensive measurement. Focus on trend analysis \u2014 are your citation rates growing month over month? Which content types earn the most citations?"
  }
};

var currentCat = 0;
var answers = {};

function getTotalAnswered() { return Object.keys(answers).length; }
function getTotalQuestions() { var t=0; CATEGORIES.forEach(function(c){t+=c.questions.length;}); return t; }

function renderCategory() {
  var cat = CATEGORIES[currentCat];
  document.getElementById('catLabel').textContent = 'Gap ' + (currentCat+1) + ' of ' + CATEGORIES.length;
  document.getElementById('catTitle').textContent = cat.title;
  document.getElementById('catRef').innerHTML = 'From the article: <em>\u201C' + cat.gap + '\u201D</em>';

  var qc = document.getElementById('questionsContainer');
  qc.innerHTML = '';
  cat.questions.forEach(function(q, qi) {
    var key = currentCat + '-' + qi;
    var sel = answers[key];
    var div = document.createElement('div');
    div.className = 'sc-question' + (sel !== undefined ? ' answered' : '');
    div.innerHTML = '<div class="sc-question-text">' + q.text + '</div>' +
      '<div class="sc-options">' +
        '<button class="sc-opt' + (sel===2?' sel-yes':'') + '" onclick="answer('+qi+',2)">Yes</button>' +
        '<button class="sc-opt' + (sel===1?' sel-partial':'') + '" onclick="answer('+qi+',1)">Partially</button>' +
        '<button class="sc-opt' + (sel===0?' sel-no':'') + '" onclick="answer('+qi+',0)">No</button>' +
      '</div>';
    qc.appendChild(div);
  });

  document.getElementById('btnBack').disabled = currentCat === 0;
  updateNextBtn();
  renderSteps();
  updateProgress();
}

function answer(qi, val) {
  answers[currentCat + '-' + qi] = val;
  renderCategory();
}

function allCurrentAnswered() {
  var cat = CATEGORIES[currentCat];
  for (var i=0; i<cat.questions.length; i++) {
    if (answers[currentCat+'-'+i] === undefined) return false;
  }
  return true;
}

function updateNextBtn() {
  var btn = document.getElementById('btnNext');
  var ready = allCurrentAnswered();
  btn.className = 'sc-btn-next' + (ready ? ' active' : '');
  btn.textContent = currentCat < CATEGORIES.length - 1 ? 'Next Gap \u2192' : 'See My Score \u2192';
}

function renderSteps() {
  var sc = document.getElementById('stepsContainer');
  sc.innerHTML = '';
  for (var i=0; i<CATEGORIES.length; i++) {
    var s = document.createElement('div');
    var cls = 'sc-step';
    if (i === currentCat) cls += ' current';
    else if (i < currentCat) cls += ' done';
    s.className = cls;
    if (i < currentCat) { s.setAttribute('data-idx', i); s.onclick = function(){ currentCat=parseInt(this.getAttribute('data-idx')); renderCategory(); }; }
    sc.appendChild(s);
  }
}

function updateProgress() {
  var pct = (getTotalAnswered() / getTotalQuestions()) * 100;
  document.getElementById('progressBar').style.width = pct + '%';
}

function goNext() {
  if (!allCurrentAnswered()) return;
  if (currentCat < CATEGORIES.length - 1) {
    currentCat++;
    renderCategory();
    window.scrollTo({top:0,behavior:'smooth'});
  } else {
    showResults();
  }
}

function goBack() {
  if (document.getElementById('resultsSection').classList.contains('visible')) {
    document.getElementById('resultsSection').classList.remove('visible');
    document.getElementById('quizSection').classList.remove('hidden');
    renderCategory();
    return;
  }
  if (currentCat > 0) { currentCat--; renderCategory(); }
}

function getCatScore(ci) {
  var cat = CATEGORIES[ci];
  var score=0, max=0;
  cat.questions.forEach(function(q,qi){
    max += q.weight * 2;
    var a = answers[ci+'-'+qi];
    if (a !== undefined) score += a * q.weight;
  });
  return {score:score, max:max, pct: max>0?(score/max)*100:0};
}

function getGrade(pct) {
  if (pct>=85) return {letter:'A',label:'AEO Leader',color:'#2D6A4F',desc:'Your content strategy is well-adapted to AI search. Focus on maintaining freshness and expanding platform-specific optimization.'};
  if (pct>=70) return {letter:'B',label:'Mostly Adapted',color:'#3A7D5C',desc:'Strong foundation with specific gaps. Closing these gaps will significantly improve your AI citation rates.'};
  if (pct>=50) return {letter:'C',label:'Partially Adapted',color:'#B8860B',desc:'You\u2019ve started the transition but critical gaps remain. AI platforms are likely citing your competitors more often.'};
  if (pct>=30) return {letter:'D',label:'Falling Behind',color:'#C75000',desc:'Major gaps across most categories. Your content is largely invisible to AI search platforms.'};
  return {letter:'F',label:'Still in 2019',color:'#B8145A',desc:'Your content strategy hasn\u2019t adapted to AI search. Every month of delay compounds your competitors\u2019 citation advantage.'};
}

function barColor(pct) { return pct>=70?'#2D6A4F':pct>=40?'#B8860B':'#B8145A'; }

function getRec(id, pct) {
  if (pct<40) return RECS[id].low;
  if (pct<75) return RECS[id].mid;
  return RECS[id].high;
}

function showResults() {
  document.getElementById('quizSection').classList.add('hidden');
  document.getElementById('resultsSection').classList.add('visible');
  document.getElementById('progressBar').style.width = '100%';

  var catScores = [];
  var totalScore=0, totalMax=0;
  CATEGORIES.forEach(function(c,i){
    var s = getCatScore(i);
    catScores.push(s);
    totalScore += s.score;
    totalMax += s.max;
  });

  var totalPct = totalMax>0?(totalScore/totalMax)*100:0;
  var grade = getGrade(totalPct);

  // Ring animation
  var circ = 2 * Math.PI * 80;
  var ringEl = document.getElementById('ringCircle');
  ringEl.setAttribute('stroke', grade.color);
  setTimeout(function(){ ringEl.style.strokeDashoffset = circ - (totalPct/100)*circ; }, 100);

  document.getElementById('gradeLetter').style.color = grade.color;
  document.getElementById('gradeLetter').textContent = grade.letter;
  document.getElementById('gradePct').textContent = Math.round(totalPct) + '%';
  document.getElementById('gradeLabel').textContent = grade.label;
  document.getElementById('gradeDesc').textContent = grade.desc;

  // Bars
  var bc = document.getElementById('barsContainer');
  bc.innerHTML = '';
  CATEGORIES.forEach(function(c,i){
    var pct = catScores[i].pct;
    var col = barColor(pct);
    var row = document.createElement('div');
    row.className = 'sc-bar-row';
    row.innerHTML = '<div class="sc-bar-header"><span class="sc-bar-name">'+c.title+'</span><span class="sc-bar-pct" style="color:'+col+'">'+Math.round(pct)+'%</span></div>' +
      '<div class="sc-bar-track"><div class="sc-bar-fill" data-pct="'+pct+'" style="background:'+col+'"></div></div>';
    bc.appendChild(row);
  });

  // Animate bars
  setTimeout(function(){
    var fills = bc.querySelectorAll('.sc-bar-fill');
    fills.forEach(function(f,i){
      setTimeout(function(){ f.style.width = f.getAttribute('data-pct')+'%'; }, i*120);
    });
  }, 100);

  // Recommendations (weakest 3)
  var ranked = catScores.map(function(s,i){ return {pct:s.pct, id:CATEGORIES[i].id, title:CATEGORIES[i].title, idx:i}; });
  ranked.sort(function(a,b){ return a.pct - b.pct; });
  var weakest = ranked.slice(0,3);

  var rc = document.getElementById('recsContainer');
  rc.innerHTML = '';
  weakest.forEach(function(w,i){
    var div = document.createElement('div');
    div.className = 'sc-rec' + (i===0?' primary':'');
    div.innerHTML = '<div class="sc-rec-header">' +
      '<span class="sc-rec-num">'+(i+1)+'.</span>' +
      '<span class="sc-rec-title">'+w.title+'<span class="sc-rec-score">'+Math.round(w.pct)+'%</span></span>' +
      '</div>' +
      '<div class="sc-rec-text">'+getRec(w.id, w.pct)+'</div>';
    rc.appendChild(div);
  });

  window.scrollTo({top:0,behavior:'smooth'});
}

function restart() {
  answers = {};
  currentCat = 0;
  document.getElementById('resultsSection').classList.remove('visible');
  document.getElementById('quizSection').classList.remove('hidden');
  document.getElementById('ringCircle').style.strokeDashoffset = '502.65';
  renderCategory();
  window.scrollTo({top:0,behavior:'smooth'});
}

// Init
renderCategory();
</script>

</body>
</html>
