import { Typography } from '@mui/material'

type ParagraphHelperProps = {
  text: string
}

const ParagraphHelper = ({ text }: ParagraphHelperProps) => {
  return (
    <Typography
      variant="body1"
      sx={{ textAlign: "justify", mb: 2, color: "text.primary" }}
      component="div"
      dangerouslySetInnerHTML={{ __html: text }}
    />
  )
}

export default ParagraphHelper