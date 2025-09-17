import { Typography } from '@mui/material'

const SectionTitle = ({ title }: { title: string }) => {
  return (
      <Typography
          variant="h3"
          textAlign="center"
          fontWeight="bold"
          sx={{ color: 'primary.main', fontFamily: "Kelly Slab" }}
          mb={6}
      >
          {title}
      </Typography>
  )
}

export default SectionTitle