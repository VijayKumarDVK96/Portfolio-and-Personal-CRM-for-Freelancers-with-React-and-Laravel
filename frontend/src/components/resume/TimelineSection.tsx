import React from "react";
import { Timeline, TimelineItem, TimelineSeparator, TimelineConnector, TimelineContent, TimelineDot, timelineItemClasses } from "@mui/lab";
import { Typography, Box, Grid, Paper, Avatar, useTheme } from "@mui/material";

interface TimelineData {
    year: string;
    title: string;
    organization: string;
    description: string | null;
    logo: string;
}

interface TimelineSectionProps {
    icon: React.ReactElement;
    title: string;
    data: TimelineData[];
}

const TimelineSection: React.FC<TimelineSectionProps> = ({ icon, title, data }) => {
    const theme = useTheme();

    // Create a styled icon with proper typing
    const StyledIcon = React.cloneElement(icon, {
        style: { 
            fontSize: 28, 
            color: theme.palette.primary.main 
        }
    });

    return (
        <Grid size={{ xs: 12, md: 6 }}>
            <Box
                sx={{
                    display: "flex",
                    alignItems: "center",
                    mb: 3,
                    color: theme.palette.primary.main,
                }}
            >
                <Box
                    sx={{
                        bgcolor: "#121821",
                        borderRadius: "50%",
                        p: 1.2,
                        display: "flex",
                        alignItems: "center",
                        justifyContent: "center",
                        mr: 1,
                        boxShadow: "0 0 8px rgba(166, 255, 0, 0.5)",
                    }}
                >
                    {StyledIcon}
                </Box>
                <Typography variant="h6" fontWeight="bold">
                    {title}
                </Typography>
            </Box>

            {/* Timeline */}
            <Timeline
                sx={{
                    [`& .${timelineItemClasses.root}:before`]: {
                        flex: 0,
                        padding: 0,
                    },
                }}
            >
                {data.map((item, idx) => (
                    <TimelineItem key={idx}>
                        <TimelineSeparator>
                            <TimelineDot sx={{ bgcolor: theme.palette.primary.main, p: 0.3 }}>
                                <Avatar 
                                    src={item.logo} 
                                    alt={item.organization} 
                                    sx={{ 
                                        width: 70, 
                                        height: 70, 
                                        "& img": { objectFit: 'contain' } 
                                    }} 
                                />
                            </TimelineDot>
                            {idx < data.length - 1 && (
                                <TimelineConnector sx={{ bgcolor: theme.palette.primary.main }} />
                            )}
                        </TimelineSeparator>

                        <TimelineContent>
                            <Paper
                                sx={{
                                    p: 2,
                                    backgroundColor: "#121821",
                                }}
                                elevation={3}
                            >
                                <Typography fontWeight="bold" variant="subtitle1">
                                    {item.title}
                                </Typography>
                                <Typography
                                    sx={{
                                        color: theme.palette.primary.main,
                                        fontWeight: 600,
                                    }}
                                >
                                    {item.organization}
                                </Typography>
                                <Typography sx={{ fontSize: 14, color: theme.palette.primary.main }}>
                                    {item.year}
                                </Typography>
                                {item.description && (
                                    <Typography 
                                        variant="body2" 
                                        color="text.primary" 
                                        sx={{ mt: 2, whiteSpace: "pre-line", textAlign: "justify" }}
                                    >
                                        {item.description}
                                    </Typography>
                                )}
                            </Paper>
                        </TimelineContent>
                    </TimelineItem>
                ))}
            </Timeline>
        </Grid>
    );
};

export default TimelineSection;
export type { TimelineData };