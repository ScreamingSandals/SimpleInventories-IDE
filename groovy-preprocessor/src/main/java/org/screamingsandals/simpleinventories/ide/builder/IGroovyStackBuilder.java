package org.screamingsandals.simpleinventories.ide.builder;

import java.util.List;
import java.util.Map;

public interface IGroovyStackBuilder {
    void amount(int amount);

    void lore(List<String> lore);

    void name(String name);

    void type(String type);

    default void damage(short damage) {
        durability(damage);
    }

    void durability(short durability);

    void customModelData(int data);

    void repair(int repair);

    void flags(List<Object> flags);

    void unbreakable(boolean unbreakable);

    default void enchant(String enchant) {
        enchant(enchant, 1);
    }

    void enchant(String enchant, int level);

    default void enchant(Map<Object, Integer> map) {
        map.forEach((key, value) -> {
            enchant(key.toString(), value);
        });
    }

    default void enchant(List<Object> list) {
        list.forEach(enchant -> {
            enchant(enchant.toString());
        });
    }

    void potion(String potion);
}