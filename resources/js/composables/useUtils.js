export const useUtils = () => {
    const getOrdinal = (num) => {
        if (num % 10 === 1) return `${num}st`;
        else if (num % 10 === 2) return `${num}nd`;
        else if (num % 10 === 3) return `${num}rd`;
        else return `${num}th`;
    };

    const formatDate = (date) => {
        const options = {
            year: "numeric",
            month: "long",
            day: "numeric",
            hour: "2-digit",
            minute: "2-digit",
        };
        return new Date(date).toLocaleDateString("en-US", options);
    };

    return { getOrdinal, formatDate };
};
