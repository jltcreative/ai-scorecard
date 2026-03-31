import { useState, useRef, useEffect } from "react";

const CATEGORIES = [
  {
    id: "extraction",
    title: "Content Extractability",
    gap: "Writing for Keywords, Not Extraction",
    questions: [
      { text: "Do your articles lead with a direct answer in the first 40 words of each section?", weight: 3 },
      { text: "Are your content sections self-contained — could each stand alone and still make sense?", weight: 3 },
      { text: "Do you front-load factual claims with specific data before expanding with context?", weight: 2 },
    ],
  },
  {
    id: "entities",
    title: "Entity Strategy",
    gap: "Not Thinking About Entities",
    questions: [
      { text: "Does your content name specific people, companies, products, and frameworks (not just generic terms)?", weight: 3 },
      { text: "Do you map entity relationships — connecting products to parent companies, founders, and competitors?", weight: 2 },
      { text: "Does each article reference 15+ recognized entities relevant to the topic?", weight: 2 },
    ],
  },
  {
    id: "schema",
    title: "Schema Markup",
    gap: "Ignoring Schema Markup",
    questions: [
      { text: "Is Article/BlogPosting schema implemented on every content page?", weight: 3 },
      { text: "Do you use FAQ, HowTo, or other content-specific schema types where relevant?", weight: 2 },
      { text: "Is Author schema with credentials and Organization schema in place?", weight: 2 },
    ],
  },
  {
    id: "testing",
    title: "AI Platform Testing",
    gap: "Never Testing on AI Platforms",
    questions: [
      { text: "Do you test content on ChatGPT, Perplexity, and Google AI before or after publishing?", weight: 3 },
      { text: "Do you run target queries to check if your content appears in AI-generated answers?", weight: 3 },
      { text: "Do you document which competitors are cited instead of you?", weight: 2 },
    ],
  },
  {
    id: "platforms",
    title: "Platform Differences",
    gap: "Not Accounting for Platform Differences",
    questions: [
      { text: "Do you understand that ChatGPT, Perplexity, and Google AI Overviews have different citation preferences?", weight: 2 },
      { text: "Do you optimize differently for each major AI platform?", weight: 3 },
      { text: "Do you track which platforms cite your content vs. competitors?", weight: 2 },
    ],
  },
  {
    id: "freshness",
    title: "Content Freshness",
    gap: "Not Building for Freshness",
    questions: [
      { text: "Do you update published content at least every 90 days?", weight: 3 },
      { text: "Is there a systematic refresh calendar (not ad-hoc updates)?", weight: 2 },
      { text: "Do refreshed articles include updated dates, new data points, and current sources?", weight: 2 },
    ],
  },
  {
    id: "metrics",
    title: "AI Metrics",
    gap: "Measuring the Wrong Things",
    questions: [
      { text: "Do you track AI citation frequency across platforms?", weight: 3 },
      { text: "Do you measure share of voice in AI-generated responses for your key topics?", weight: 2 },
      { text: "Do you report on AI visibility alongside traditional SEO metrics?", weight: 2 },
    ],
  },
];

const ANSWER_OPTIONS = [
  { label: "Yes", value: 2, color: "#2D6A4F" },
  { label: "Partially", value: 1, color: "#B8860B" },
  { label: "No", value: 0, color: "#B8145A" },
];

function getGrade(pct) {
  if (pct >= 85) return { letter: "A", label: "AEO Leader", color: "#2D6A4F", desc: "Your content strategy is well-adapted to AI search. Focus on maintaining freshness and expanding platform-specific optimization." };
  if (pct >= 70) return { letter: "B", label: "Mostly Adapted", color: "#3A7D5C", desc: "Strong foundation with specific gaps. Closing these gaps will significantly improve your AI citation rates." };
  if (pct >= 50) return { letter: "C", label: "Partially Adapted", color: "#B8860B", desc: "You've started the transition but critical gaps remain. AI platforms are likely citing your competitors more often." };
  if (pct >= 30) return { letter: "D", label: "Falling Behind", color: "#C75000", desc: "Major gaps across most categories. Your content is largely invisible to AI search platforms." };
  return { letter: "F", label: "Still in 2019", color: "#B8145A", desc: "Your content strategy hasn't adapted to AI search. Every month of delay compounds your competitors' citation advantage." };
}

function getCategoryRecommendation(id, score, max) {
  const pct = max > 0 ? (score / max) * 100 : 0;
  const recs = {
    extraction: {
      low: "Restructure every article section to lead with a direct answer in the first 1–2 sentences. Each passage should be self-contained and citable without surrounding context.",
      mid: "Your structure is partially there. Audit your top 10 pages and ensure every H2 section opens with an extractable answer block under 40 words.",
      high: "Strong extractability. Keep refining passage isolation and ensure new content follows the same answer-first pattern.",
    },
    entities: {
      low: "Start entity mapping before writing. List every specific person, company, product, and concept relevant to each topic. Aim for 15+ named entities per article.",
      mid: "You're naming some entities but missing relationship mapping. Connect products to parent companies, founders to organizations, and tools to use cases.",
      high: "Solid entity coverage. Consider building an entity database for your key topics to ensure consistency across articles.",
    },
    schema: {
      low: "Implement Article/BlogPosting schema immediately on all content pages. Add Author schema with credentials and Organization schema. This is baseline infrastructure, not optional.",
      mid: "You have basic schema in place. Add FAQ schema to Q&A sections and ensure Author schema includes expertise signals and linked profiles.",
      high: "Good schema foundation. Audit for completeness — ensure dateModified updates with every refresh and all content types use appropriate schema.",
    },
    testing: {
      low: "Build a testing protocol: run 5–10 target queries on ChatGPT, Perplexity, and Google AI for every published article. Document what gets cited and what doesn't.",
      mid: "You're testing but not systematically. Create a standardized testing checklist and track results over time to identify patterns.",
      high: "Strong testing habits. Expand to include pre-publication testing so you can adjust structure before content goes live.",
    },
    platforms: {
      low: "Study platform differences. ChatGPT relies on Bing, Perplexity runs its own crawlers, Google uses its own index. Each requires different optimization. Start tracking which platforms cite you.",
      mid: "You understand the differences conceptually. Now build platform-specific checklists and track citation rates per platform to identify where you're weakest.",
      high: "Advanced platform awareness. Focus on the platforms where your audience is most active and deepen optimization for those specifically.",
    },
    freshness: {
      low: "Set up a 90-day refresh calendar for all published content. Update dates, add new data points, and refresh sources. AI platforms deprioritize stale content aggressively.",
      mid: "You refresh some content but not systematically. Prioritize your highest-traffic articles and build freshness into your editorial calendar.",
      high: "Good refresh discipline. Ensure every update includes genuinely new information — not just cosmetic date changes, which AI platforms can detect.",
    },
    metrics: {
      low: "Start tracking AI citations manually: query your key topics on ChatGPT, Perplexity, and Google AI monthly. Note which brands are cited. Tools like Semrush's AI Visibility and HubSpot's AI Search Grader can help automate this.",
      mid: "You're tracking some AI metrics but not reporting on them consistently. Build AI visibility into your regular reporting alongside traditional SEO KPIs.",
      high: "Comprehensive measurement. Focus on trend analysis — are your citation rates growing month over month? Which content types earn the most citations?",
    },
  };
  if (pct < 40) return recs[id].low;
  if (pct < 75) return recs[id].mid;
  return recs[id].high;
}

const ProgressRing = ({ pct, size = 160, stroke = 10, color }) => {
  const r = (size - stroke) / 2;
  const circ = 2 * Math.PI * r;
  const [offset, setOffset] = useState(circ);
  useEffect(() => {
    const t = setTimeout(() => setOffset(circ - (pct / 100) * circ), 100);
    return () => clearTimeout(t);
  }, [pct, circ]);
  return (
    <svg width={size} height={size} style={{ transform: "rotate(-90deg)" }}>
      <circle cx={size / 2} cy={size / 2} r={r} fill="none" stroke="#D4CCBF" strokeWidth={stroke} opacity={0.4} />
      <circle cx={size / 2} cy={size / 2} r={r} fill="none" stroke={color} strokeWidth={stroke} strokeDasharray={circ} strokeDashoffset={offset} strokeLinecap="round" style={{ transition: "stroke-dashoffset 1.2s cubic-bezier(0.4,0,0.2,1)" }} />
    </svg>
  );
};

const CategoryBar = ({ label, score, max, delay }) => {
  const pct = max > 0 ? (score / max) * 100 : 0;
  const [visible, setVisible] = useState(false);
  useEffect(() => { const t = setTimeout(() => setVisible(true), delay); return () => clearTimeout(t); }, [delay]);
  const barColor = pct >= 70 ? "#2D6A4F" : pct >= 40 ? "#B8860B" : "#B8145A";
  return (
    <div style={{ marginBottom: 14 }}>
      <div style={{ display: "flex", justifyContent: "space-between", marginBottom: 5, fontFamily: "'DM Sans', sans-serif", fontSize: 13, color: "#1B1815" }}>
        <span style={{ fontWeight: 600 }}>{label}</span>
        <span style={{ color: barColor, fontWeight: 600 }}>{Math.round(pct)}%</span>
      </div>
      <div style={{ height: 6, background: "#EDE8E0", borderRadius: 3, overflow: "hidden" }}>
        <div style={{ height: "100%", width: visible ? `${pct}%` : "0%", background: barColor, borderRadius: 3, transition: "width 0.8s cubic-bezier(0.4,0,0.2,1)" }} />
      </div>
    </div>
  );
};

export default function AEOScorecard() {
  const [currentCat, setCurrentCat] = useState(0);
  const [answers, setAnswers] = useState({});
  const [showResults, setShowResults] = useState(false);
  const resultsRef = useRef(null);

  const cat = CATEGORIES[currentCat];
  const totalQuestions = CATEGORIES.reduce((s, c) => s + c.questions.length, 0);
  const answeredCount = Object.keys(answers).length;
  const allAnswered = cat ? cat.questions.every((_, qi) => answers[`${currentCat}-${qi}`] !== undefined) : false;

  const handleAnswer = (qi, value) => {
    setAnswers((prev) => ({ ...prev, [`${currentCat}-${qi}`]: value }));
  };

  const nextCategory = () => {
    if (currentCat < CATEGORIES.length - 1) {
      setCurrentCat((p) => p + 1);
    } else {
      setShowResults(true);
      setTimeout(() => resultsRef.current?.scrollIntoView({ behavior: "smooth" }), 200);
    }
  };

  const prevCategory = () => {
    if (showResults) { setShowResults(false); return; }
    if (currentCat > 0) setCurrentCat((p) => p - 1);
  };

  const restart = () => { setAnswers({}); setCurrentCat(0); setShowResults(false); };

  // Scoring
  const categoryScores = CATEGORIES.map((c, ci) => {
    let score = 0, max = 0;
    c.questions.forEach((q, qi) => {
      max += q.weight * 2;
      const a = answers[`${ci}-${qi}`];
      if (a !== undefined) score += a * q.weight;
    });
    return { score, max, pct: max > 0 ? (score / max) * 100 : 0 };
  });

  const totalScore = categoryScores.reduce((s, c) => s + c.score, 0);
  const totalMax = categoryScores.reduce((s, c) => s + c.max, 0);
  const totalPct = totalMax > 0 ? (totalScore / totalMax) * 100 : 0;
  const grade = getGrade(totalPct);

  const weakest = categoryScores
    .map((s, i) => ({ ...s, ...CATEGORIES[i], idx: i }))
    .sort((a, b) => a.pct - b.pct)
    .slice(0, 3);

  return (
    <div style={{ fontFamily: "'DM Sans', sans-serif", background: "#F8F4ED", minHeight: "100vh", padding: "0" }}>
      <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet" />

      {/* Header */}
      <div style={{ background: "#1B1815", padding: "40px 32px 36px", textAlign: "center" }}>
        <div style={{ fontFamily: "'Playfair Display', serif", fontSize: 28, fontWeight: 400, color: "#F8F4ED", marginBottom: 8, lineHeight: 1.2 }}>
          AEO Readiness Scorecard
        </div>
        <div style={{ fontSize: 14, color: "#8A7F75", maxWidth: 480, margin: "0 auto", lineHeight: 1.5 }}>
          Rate your content strategy across 7 critical AI search dimensions. Get your score and specific recommendations.
        </div>
      </div>

      {/* Progress bar */}
      <div style={{ background: "#EDE8E0", height: 3 }}>
        <div style={{
          height: "100%",
          width: showResults ? "100%" : `${((answeredCount) / totalQuestions) * 100}%`,
          background: "#B8145A",
          transition: "width 0.4s ease",
        }} />
      </div>

      <div style={{ maxWidth: 640, margin: "0 auto", padding: "32px 24px 48px" }}>

        {!showResults ? (
          <>
            {/* Category header */}
            <div style={{ marginBottom: 28 }}>
              <div style={{ fontSize: 10, fontWeight: 600, textTransform: "uppercase", letterSpacing: "0.12em", color: "#B8145A", marginBottom: 8 }}>
                Gap {currentCat + 1} of {CATEGORIES.length}
              </div>
              <div style={{ fontFamily: "'Playfair Display', serif", fontSize: 24, fontWeight: 400, color: "#1B1815", marginBottom: 6, lineHeight: 1.25 }}>
                {cat.title}
              </div>
              <div style={{ fontSize: 13, color: "#8A7F75", lineHeight: 1.5 }}>
                From the article: <em>"{cat.gap}"</em>
              </div>
            </div>

            {/* Questions */}
            <div style={{ display: "flex", flexDirection: "column", gap: 20 }}>
              {cat.questions.map((q, qi) => {
                const key = `${currentCat}-${qi}`;
                const selected = answers[key];
                return (
                  <div key={key} style={{
                    background: "#fff",
                    border: "0.5px solid #D4CCBF",
                    padding: "20px 24px",
                    transition: "border-color 0.2s",
                    borderColor: selected !== undefined ? "#B8145A" : "#D4CCBF",
                  }}>
                    <div style={{ fontSize: 15, color: "#1B1815", lineHeight: 1.55, marginBottom: 14, fontWeight: 500 }}>
                      {q.text}
                    </div>
                    <div style={{ display: "flex", gap: 10 }}>
                      {ANSWER_OPTIONS.map((opt) => {
                        const isSelected = selected === opt.value;
                        return (
                          <button
                            key={opt.value}
                            onClick={() => handleAnswer(qi, opt.value)}
                            style={{
                              flex: 1,
                              padding: "10px 0",
                              fontSize: 13,
                              fontWeight: 600,
                              fontFamily: "'DM Sans', sans-serif",
                              letterSpacing: "0.02em",
                              border: isSelected ? `2px solid ${opt.color}` : "1.5px solid #D4CCBF",
                              background: isSelected ? opt.color : "transparent",
                              color: isSelected ? "#F8F4ED" : "#1B1815",
                              cursor: "pointer",
                              transition: "all 0.15s ease",
                            }}
                          >
                            {opt.label}
                          </button>
                        );
                      })}
                    </div>
                  </div>
                );
              })}
            </div>

            {/* Navigation */}
            <div style={{ display: "flex", justifyContent: "space-between", marginTop: 32, gap: 12 }}>
              <button
                onClick={prevCategory}
                disabled={currentCat === 0}
                style={{
                  padding: "12px 24px", fontSize: 13, fontWeight: 600, fontFamily: "'DM Sans', sans-serif",
                  border: "1.5px solid #D4CCBF", background: "transparent", color: currentCat === 0 ? "#D4CCBF" : "#1B1815",
                  cursor: currentCat === 0 ? "default" : "pointer", transition: "all 0.2s",
                }}
              >
                ← Back
              </button>
              <button
                onClick={nextCategory}
                disabled={!allAnswered}
                style={{
                  padding: "12px 32px", fontSize: 13, fontWeight: 600, fontFamily: "'DM Sans', sans-serif",
                  letterSpacing: "0.03em", border: "none",
                  background: allAnswered ? "#B8145A" : "#D4CCBF",
                  color: "#F8F4ED",
                  cursor: allAnswered ? "pointer" : "default",
                  transition: "all 0.2s",
                }}
              >
                {currentCat < CATEGORIES.length - 1 ? "Next Gap →" : "See My Score →"}
              </button>
            </div>

            {/* Step indicators */}
            <div style={{ display: "flex", justifyContent: "center", gap: 8, marginTop: 24 }}>
              {CATEGORIES.map((_, i) => (
                <div
                  key={i}
                  onClick={() => {
                    const canNavigate = CATEGORIES.slice(0, i).every((c, ci) =>
                      c.questions.every((_, qi) => answers[`${ci}-${qi}`] !== undefined)
                    );
                    if (canNavigate || i <= currentCat) { setShowResults(false); setCurrentCat(i); }
                  }}
                  style={{
                    width: 28, height: 4,
                    background: i === currentCat ? "#B8145A" : i < currentCat ? "#1B1815" : "#D4CCBF",
                    borderRadius: 2,
                    cursor: i <= currentCat ? "pointer" : "default",
                    transition: "background 0.3s",
                  }}
                />
              ))}
            </div>
          </>
        ) : (
          /* Results */
          <div ref={resultsRef}>
            {/* Score circle */}
            <div style={{ textAlign: "center", marginBottom: 36 }}>
              <div style={{ position: "relative", display: "inline-block" }}>
                <ProgressRing pct={totalPct} size={180} stroke={10} color={grade.color} />
                <div style={{ position: "absolute", top: "50%", left: "50%", transform: "translate(-50%, -50%) rotate(0deg)", textAlign: "center" }}>
                  <div style={{ fontFamily: "'Playfair Display', serif", fontSize: 52, fontWeight: 400, color: grade.color, lineHeight: 1 }}>
                    {grade.letter}
                  </div>
                  <div style={{ fontSize: 11, fontWeight: 600, color: "#8A7F75", textTransform: "uppercase", letterSpacing: "0.1em", marginTop: 2 }}>
                    {Math.round(totalPct)}%
                  </div>
                </div>
              </div>
              <div style={{ fontFamily: "'Playfair Display', serif", fontSize: 22, color: "#1B1815", marginTop: 16, fontWeight: 400 }}>
                {grade.label}
              </div>
              <div style={{ fontSize: 14, color: "#8A7F75", maxWidth: 440, margin: "8px auto 0", lineHeight: 1.55 }}>
                {grade.desc}
              </div>
            </div>

            {/* Category breakdown */}
            <div style={{ background: "#fff", border: "0.5px solid #D4CCBF", padding: "24px 28px", marginBottom: 28 }}>
              <div style={{ fontSize: 10, fontWeight: 600, textTransform: "uppercase", letterSpacing: "0.12em", color: "#8A7F75", marginBottom: 18 }}>
                Score Breakdown
              </div>
              {CATEGORIES.map((c, i) => (
                <CategoryBar key={c.id} label={c.title} score={categoryScores[i].score} max={categoryScores[i].max} delay={i * 120} />
              ))}
            </div>

            {/* Top recommendations */}
            <div style={{ marginBottom: 32 }}>
              <div style={{ fontSize: 10, fontWeight: 600, textTransform: "uppercase", letterSpacing: "0.12em", color: "#8A7F75", marginBottom: 16 }}>
                Priority Recommendations
              </div>
              {weakest.map((w, i) => (
                <div key={w.id} style={{
                  background: i === 0 ? "#1B1815" : "#fff",
                  border: i === 0 ? "none" : "0.5px solid #D4CCBF",
                  padding: "20px 24px",
                  marginBottom: 12,
                }}>
                  <div style={{ display: "flex", alignItems: "center", gap: 10, marginBottom: 8 }}>
                    <span style={{
                      fontFamily: "'Playfair Display', serif", fontSize: 20, fontWeight: 400,
                      color: i === 0 ? "#B8145A" : "#B8145A", lineHeight: 1,
                    }}>
                      {i + 1}.
                    </span>
                    <span style={{
                      fontSize: 14, fontWeight: 600,
                      color: i === 0 ? "#F8F4ED" : "#1B1815",
                    }}>
                      {w.title}
                      <span style={{ fontWeight: 400, color: i === 0 ? "#8A7F75" : "#8A7F75", marginLeft: 8, fontSize: 12 }}>
                        {Math.round(w.pct)}%
                      </span>
                    </span>
                  </div>
                  <div style={{
                    fontSize: 13, lineHeight: 1.6,
                    color: i === 0 ? "#D4CCBF" : "#8A7F75",
                  }}>
                    {getCategoryRecommendation(w.id, categoryScores[w.idx].score, categoryScores[w.idx].max)}
                  </div>
                </div>
              ))}
            </div>

            {/* CTA */}
            <div style={{ background: "#1B1815", padding: "36px 28px", textAlign: "center" }}>
              <div style={{ fontFamily: "'Playfair Display', serif", fontSize: 22, fontWeight: 400, color: "#F8F4ED", marginBottom: 8 }}>
                Want to Close These Gaps?
              </div>
              <div style={{ fontSize: 13, color: "#8A7F75", lineHeight: 1.5, maxWidth: 380, margin: "0 auto 20px" }}>
                Every article we create is AEO-optimized, schema-marked, and tested across 5 AI platforms before delivery.
              </div>
              <a
                href="https://www.golacocontent.com/get-a-quote/"
                target="_blank"
                rel="noopener noreferrer"
                style={{
                  display: "inline-flex", alignItems: "center", gap: 8,
                  fontFamily: "'DM Sans', sans-serif", fontSize: 14, fontWeight: 600,
                  letterSpacing: "0.04em", color: "#1B1815", background: "#F8F4ED",
                  border: "none", padding: "14px 32px", textDecoration: "none",
                  cursor: "pointer", transition: "all 0.2s",
                }}
                onMouseEnter={(e) => { e.target.style.background = "#B8145A"; e.target.style.color = "#F8F4ED"; }}
                onMouseLeave={(e) => { e.target.style.background = "#F8F4ED"; e.target.style.color = "#1B1815"; }}
              >
                Get a Free Quote
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
              </a>
            </div>

            {/* Restart */}
            <div style={{ textAlign: "center", marginTop: 24 }}>
              <button
                onClick={restart}
                style={{
                  fontFamily: "'DM Sans', sans-serif", fontSize: 12, fontWeight: 600,
                  color: "#8A7F75", background: "transparent", border: "none",
                  cursor: "pointer", textDecoration: "underline", textUnderlineOffset: 3,
                }}
              >
                Retake Assessment
              </button>
            </div>
          </div>
        )}
      </div>

      {/* Footer */}
      <div style={{ textAlign: "center", padding: "16px 24px 24px", fontSize: 11, color: "#8A7F75" }}>
        Built by <a href="https://www.golacocontent.com" target="_blank" rel="noopener noreferrer" style={{ color: "#B8145A", textDecoration: "none" }}>LA & CO Content Agency</a>
      </div>
    </div>
  );
}
