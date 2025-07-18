import React, { useEffect, useState } from "react";
import {
  BarChart,
  Bar,
  CartesianGrid,
  ResponsiveContainer,
  Tooltip,
  XAxis,
  YAxis,
  Cell,
  LabelList,
} from "recharts";

const getBarColor = (level) => {
  if (level >= 90) return "#16a34a";
  if (level >= 75) return "#f59e0b";
  return "#ef4444";
};

export default function AboutComponent() {
  const [skills, setSkills] = useState([]);
  const [loading, setLoading] = useState(true);
  const [selectedCategory, setSelectedCategory] = useState("All Skills");

  const fetchSkills = async () => {
    try {
      const response = await fetch("/wpaditya/wp-json/wp/v2/skill");
      const data = await response.json();
      setSkills(data);
    } catch (error) {
      console.error("Error fetching skills:", error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchSkills();
  }, []);

  // Group by category
  const groupedSkills = skills.reduce((acc, skill) => {
    const category = skill.skill_category_name?.[0] || "Uncategorized";
    if (!acc[category]) acc[category] = [];
    acc[category].push({
      name: skill.title.rendered,
      level: skill.level,
    });
    return acc;
  }, {});

  const categoryNames = ["All Skills", ...Object.keys(groupedSkills)];

  // Determine which skill set to show
  const currentSkills =
    selectedCategory === "All Skills"
      ? skills.map((skill) => ({
          name: skill.title.rendered,
          level: skill.level,
        }))
      : groupedSkills[selectedCategory] || [];

  return (
    <div className="about-container">
      <h2 className="section-title">My Tech Stack</h2>

      {loading ? (
        <p className="loading-text">Loading skills...</p>
      ) : (
        <>
          {/* Tabs */}
          <div className="category-tabs" style={{ marginBottom: "1rem" }}>
            {categoryNames.map((category) => (
              <button
                key={category}
                onClick={() => setSelectedCategory(category)}
                style={{
                  padding: "0.5rem 1rem",
                  marginRight: "1rem",
                  backgroundColor:
                    selectedCategory === category ? "#4f46e5" : "#e5e7eb",
                  color: selectedCategory === category ? "#fff" : "#000",
                  border: "none",
                  borderRadius: "5px",
                  cursor: "pointer",
                }}
              >
                {category}
              </button>
            ))}
          </div>

          {/* Chart */}
          <ResponsiveContainer
            width="100%"
            height={Math.max(300, currentSkills.length * 50)}
          >
            <BarChart
              data={currentSkills}
              margin={{ top: 20, right: 30, left: 20, bottom: 40 }}
            >
              <CartesianGrid strokeDasharray="3 3" />
              <XAxis
                dataKey="name"
                angle={-45}
                textAnchor="end"
                interval={0}
              />
              <YAxis type="number" domain={[0, 100]} />
              <Tooltip />
              <Bar dataKey="level" barSize={40}>
                <LabelList dataKey="level" position="top" />
                {currentSkills.map((entry, index) => (
                  <Cell
                    key={`bar-${index}`}
                    fill={getBarColor(entry.level)}
                  />
                ))}
              </Bar>
            </BarChart>
          </ResponsiveContainer>
        </>
      )}
    </div>
  );
}
