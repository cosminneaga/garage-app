const colors = require("tailwindcss/colors");

module.exports = {
    theme: {
        colors: {
            primary: {
                100: "#f3e8ff",
                200: "#e9d5ff",
                300: "#d8b4fe",
                400: "#c084fc",
                500: "#a855f7",
                600: "#9333ea",
                700: "#7e22ce",
                800: "#6d28d9",
                900: "#4c1d95",
            },
            gray: colors.coolGray,
            blue: colors.lightBlue,
            red: colors.black,
            pink: colors.fuchsia,
            secondary: colors.zinc,
            dark: colors.gray,
            green: colors.emerald,
        },
        fontFamily: {
            sans: ["Graphik", "sans-serif"],
            serif: ["Merriweather", "serif"],
        },
        extend: {
            spacing: {
                128: "32rem",
                144: "36rem",
            },
            borderRadius: {
                "4xl": "2rem",
            },
        },
    },
    variants: {
        extend: {
            borderColor: ["focus-visible"],
            opacity: ["disabled"],
        },
    },
};
