import React, { useMemo, useState } from "react";
import { Box, Typography, Tabs, Tab, Grid, Card, CardContent, CardActions, Chip, Stack, Link } from "@mui/material";
import { OpenInNew as OpenInNewIcon } from "@mui/icons-material";
import { Link as RouterLink } from "react-router-dom";

import SectionTitle from "../utils/SectionTitle";
import { useMain } from "../contexts/MainContext";


export interface Project {
    id: number;
    title: string | null;
    description: string;
    image: string;
    category: string;
    category_id: number;
    project_url: string | null;
    demo_url: string | null;
    technologies: string[];
    created_at: string;
}

const Projects: React.FC = () => {

    const { mainData } = useMain();

    if (!mainData) return null;

    const projects: Project[] = mainData.data.projects;

    const [selectedTab, setSelectedTab] = useState<(typeof projectCategories)[number]>("All");

    const handleChange = (_: React.SyntheticEvent, newValue: string) => {
        setSelectedTab(newValue as (typeof projectCategories)[number]);
    };

    const projectCategories = useMemo(() => {
        const cats = projects.map(p => p.category || "Uncategorized");
        const uniqueCats = Array.from(new Set(cats));
        // Prepend "All"
        return ["All", ...uniqueCats];
    }, [projects]);

    const filteredProjects = selectedTab === "All"
        ? projects
        : projects.filter((project) => project.category === selectedTab);

    return (
        <Box
            id="projects"
            sx={{
                bgcolor: "#0a111e",
                color: "primary.main",
                py: 12,
                px: { xs: 2, md: 6 },
            }}
        >
            <SectionTitle title="Projects" />

            <Tabs
                value={selectedTab}
                onChange={handleChange}
                centered
                slotProps={{
                    indicator: {
                        sx: {
                            bgcolor: "primary.main",
                            height: 36,
                            borderRadius: 1,
                            top: 6,
                            zIndex: 1,
                        },
                    },
                }}
                sx={{
                    bgcolor: "#101820",
                    mx: "auto",
                    width: "fit-content",
                    borderRadius: 1,
                    mb: 6,
                    "& .MuiTab-root": {
                        color: "#d1d5db",
                        textTransform: "none",
                        fontWeight: 600,
                        minWidth: 80,
                        zIndex: 0,
                        "&.Mui-selected": {
                            color: "#0a111e",
                            fontWeight: "bold",
                            zIndex: 2,
                        },
                    },
                }}
            >
                {projectCategories.map((category) => (
                    <Tab key={category} label={category} value={category} />
                ))}
            </Tabs>

            {/* Projects Grid */}
            <Grid
                container
                spacing={2}
                maxWidth={1200}
                sx={{ mx: "auto" }}
                justifyContent="center"
            >
                {filteredProjects.map((project) => (
                    <Grid size={{ xs: 12, sm: 6, md: 4 }} key={project.id}>
                        <Card
                            sx={{
                                bgcolor: "#1f2e0e",
                                borderRadius: 2,
                                boxShadow: "none",
                                height: 480,
                                display: "flex",
                                flexDirection: "column",
                            }}
                        >
                            {/* Project Image */}
                            <Box
                                component="img"
                                src={project.image}
                                alt={project.title ?? "Project image"}
                                sx={{
                                    height: 200,
                                    objectFit: "cover",
                                    borderTopLeftRadius: 8,
                                    borderTopRightRadius: 8,
                                    width: "100%",
                                }}
                            />

                            {/* Card Body */}
                            <CardContent sx={{ color: "#d1d5db", flexGrow: 1 }}>
                                <Typography
                                    variant="h6"
                                    fontWeight="bold"
                                    gutterBottom
                                    sx={{ color: "primary.main" }}
                                >
                                    {project.title}
                                </Typography>

                                <Typography variant="body2" mb={2} sx={{ height: '100px', color: "text.primary", textAlign: 'justify' }}>
                                    {project.description}
                                </Typography>

                                <Stack direction="row" spacing={1.5} flexWrap="wrap" mb={1}>
                                    {project.technologies.map((skill) => (
                                        <Chip
                                            key={skill}
                                            label={skill}
                                            size="small"
                                            sx={{
                                                bgcolor: "#30450e",
                                                color: "primary.main",
                                                fontWeight: 700,
                                                mb: '5px !important'
                                            }}
                                        />
                                    ))}
                                </Stack>
                            </CardContent>

                            <CardActions sx={{ px: 2, pb: 2, pt: 0, gap: 1, justifyContent: 'space-between' }}>
                                {/* {project.project_url && (
                                    <Link href={project.project_url} target="_blank" rel="noopener" sx={{ color: "primary.main" }}>
                                        Live Demo <OpenInNewIcon sx={{ fontSize: 15, ml: 0.5 }} />
                                    </Link>
                                )} */}
                                {project.demo_url && (
                                    <Link href={project.demo_url} target="_blank" rel="noopener" sx={{ color: "primary.main" }}>
                                        Demo <OpenInNewIcon sx={{ fontSize: 15, ml: 0.5 }} />
                                    </Link>
                                )}
                                <Link
                                    component={RouterLink}
                                    to={`/project-details/${project.id}`}
                                    rel="noopener"
                                    underline="none"
                                    sx={{
                                        display: "flex",
                                        alignItems: "center",
                                        color: "primary.main",
                                        fontWeight: 600,
                                        fontSize: "0.875rem",
                                        ml: 1,
                                        cursor: "pointer",
                                        textDecoration: "none",
                                    }}
                                >
                                    View Details <OpenInNewIcon sx={{ fontSize: 15, ml: 0.5 }} />
                                </Link>
                            </CardActions>
                        </Card>
                    </Grid>
                ))}
            </Grid>
        </Box>
    );
};

export default Projects;