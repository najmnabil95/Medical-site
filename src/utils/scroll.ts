export function scrollToId(id: string, offset: number = 80) {
  const el = document.getElementById(id);
  if (el) {
    const pos = el.getBoundingClientRect().top + window.pageYOffset - offset;
    window.scrollTo({ top: pos, behavior: "smooth" });
  }
}

export function createScrollHandler(id: string, offset: number = 80) {
  return (e: React.MouseEvent) => {
    e.preventDefault();
    scrollToId(id, offset);
  };
}
