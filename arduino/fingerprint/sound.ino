void playSound(int order, int vol) {
  player.volume(vol);
  player.playFolder(order, 1);
}