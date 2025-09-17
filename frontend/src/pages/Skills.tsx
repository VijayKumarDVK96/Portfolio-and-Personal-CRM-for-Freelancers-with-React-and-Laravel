import { Box, Typography, Grid } from "@mui/material";
import SectionTitle from "../utils/SectionTitle";
import { useMain } from "../contexts/MainContext";

interface Technology {
  id: number;
  name: string;
  logo: string;
}

interface SkillCategoryType {
  id: number;
  name: string;
  technologies: Technology[];
}

const SkillCategory = ({ title, items }: { title: string; items: Technology[] }) => (
  <Grid size={{ xs: 12, md: 6 }} sx={{ p: 4 }}>
    <Typography
      variant="h6"
      sx={{
        color: "text.primary",
        letterSpacing: 2,
        fontWeight: "bold",
        mb: 3,
      }}
    >
      {title.toUpperCase()}
    </Typography>

    <Grid container spacing={8}>
      {items.map(({ id, name, logo }) => (
        <Grid
          key={id}
          display="flex"
          alignItems="center"
          gap={1}
          sx={{ width: '100px'}}
        >
          <Box
            component="img"
            src={logo}
            alt={name}
            sx={{ width: 50, height: 50, objectFit: "contain", backgroundColor: "white", p: '3px', borderRadius: 1 }}
          />
          <Typography sx={{ color: "grey.100", fontSize: "1rem" }}>
            {name}
          </Typography>
        </Grid>
      ))}
    </Grid>
  </Grid>
);

const Skills = () => {

  const { mainData } = useMain();

  if (!mainData) return null;

  const skills: SkillCategoryType[] = mainData.data.skills;

  return (
    <Box
      sx={{
        position: "relative",
        color: "white",
        py: 6,
        px: 3,
        minHeight: "100vh",
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        // backgroundImage:
        //   "url('https://wallpapercat.com/w/full/b/a/9/1209998-3840x2160-desktop-4k-glow-in-the-dark-background-photo.jpg')",
        // backgroundRepeat: "no-repeat",
        // backgroundPosition: "center",
        // backgroundSize: "cover",
        "&::before": {
          content: '""',
          position: "absolute",
          inset: 0,
          bgcolor: "rgba(0,0,0,0.7)",
          zIndex: 1,
        },
        "& > *": {
          position: "relative",
          zIndex: 2,
        },
      }}
    >
      <Grid container spacing={5} maxWidth={1200} margin="0 auto">
        <Grid size={{ xs: 12 }}>
          <SectionTitle title="Skills & Technologies" />
        </Grid>

        {skills.map((category) => (
          <SkillCategory
            key={category.id}
            title={category.name}
            items={category.technologies}
          />
        ))}
      </Grid>
    </Box>
  );
};

export default Skills;