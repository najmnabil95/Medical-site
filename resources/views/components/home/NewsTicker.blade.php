@php
  // Fetch from database if available, otherwise use default
  $dbNews = [];
  try {
      if (isset($news) && $news->isNotEmpty()) {
          $dbNews = $news->pluck('title')->toArray();
      } else {
          $dbNews = \App\Models\News::orderBy('date', 'desc')->pluck('title')->toArray();
      }
  } catch (\Exception $e) {
      $dbNews = [];
  }

  $newsItems = !empty($dbNews) ? $dbNews : [
    "🎉 مستشفى الشفاء يحصل على اعتماد JCI للمرة الثالثة",
    "📢 افتتاح قسم جراحة القلب بالروبوت الجراحي",
    "🏆 جائزة أفضل مستشفى في المنطقة لعام 2024",
    "💉 حملة التطعيم المجانية متاحة الآن",
    "⭐ نسبة رضا المرضى تصل إلى 98%",
    "🔬 تدشين أحدث جهاز رنين مغناطيسي 3 تسلا",
  ];
@endphp

<div class="bg-gradient-to-l from-emerald-600 to-emerald-500 text-white py-2.5 overflow-hidden relative">
  <div class="flex items-center">
    <!-- Label -->
    <div class="bg-white/20 px-4 py-1 flex items-center gap-2 shrink-0 z-10 backdrop-blur-sm">
      <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
      <span class="text-xs font-bold whitespace-nowrap">آخر الأخبار</span>
    </div>

    <!-- Scrolling Text -->
    <div class="flex animate-marquee whitespace-nowrap">
      @foreach(array_merge($newsItems, $newsItems) as $item)
        <span class="mx-8 text-sm font-medium">
          {{ $item }}
        </span>
      @endforeach
    </div>
  </div>
</div>
